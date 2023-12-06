<?php

namespace Goldfinch\Youtube\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use Goldfinch\Youtube\Models\YoutubeVideo;
use Goldfinch\Youtube\Configs\YoutubeConfig;

class Youtube
{
    /**
     *
     * You can acquire an OAuth 2.0 client ID and client secret from the {{ Google Cloud Console }}
     * https://cloud.google.com/console
     *
     * For more information about using OAuth 2.0 to access Google APIs, please see:
     * https://developers.google.com/youtube/v3/guides/authentication
     *
     */

    const YOUTUBE_API_URL = 'https://www.googleapis.com/youtube/v3/';

    protected $youtube = [];
    protected $cfg;
    protected $client;

    public function __construct()
    {
        $this->configInit();
        $this->clientInit();
    }

    private function clientInit()
    {
        $this->client = new Client();
    }

    private function configInit()
    {
        $this->cfg = YoutubeConfig::current_config();

        $this->youtube = [
            'limit' => $this->cfg->dbObject('YoutubeLimit')->getValue(),
            'api_key' => $this->cfg->dbObject('APIKey')->getValue(),
            'channel_id' => $this->cfg->dbObject('ChannelID')->getValue(),
            'oauth2' => $this->cfg->dbObject('YoutubeOAuth2')->getValue(),
            'client_id' => $this->cfg->dbObject('ClientID')->getValue(),
            'client_secret' => $this->cfg->dbObject('ClientSecret')->getValue(),
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ];
    }

    public function YoutubeFeed()
    {
        if (!$this->cfg->YoutubeAPI)
        {
            return;
        }

        if (!$this->youtube['api_key'] || !$this->youtube['limit'] || !$this->youtube['channel_id'])
        {
            return $this->returnFailed('Missing configuration', 403);
        }

        try {
            $response = $this->client->request('GET', self::YOUTUBE_API_URL . 'search', [
                'query' => [
                    'channelId' => $this->youtube['channel_id'],
                    'key' => $this->youtube['api_key'],
                    'maxResults' => $this->youtube['limit'],
                    'part' => 'snippet,id',
                    'order' => 'date',
                ],
                'headers' => $this->youtube['headers'],
            ]);
        }
        catch (ClientException $e) {
            $response = $e->getResponse();
        }

        if ($response->getStatusCode() >= 200  && $response->getStatusCode() < 300)
        {
            $data = json_decode($response->getBody(), true);

            $this->cfg->YoutubeAPILastSync = date('Y-m-d H:i:s');
            $this->cfg->write();

            // $data['pageInfo']
            // $data['pageInfo']['totalResults]
            // $data['pageInfo']['resultsPerPage]
            // $data['nextPageToken']

            foreach ($data['items'] as $item)
            {
                $this->syncPost($item, 'video');
            }

            return $this->returnSuccess(true);

        }
        else
        {
            return $this->returnFailed($response, $response->getStatusCode());
        }
    }

    private function syncPost($item, $type)
    {
        $video = YoutubeVideo::get()->filter([
          'VideoID' => $item['id']['videoId'],
        ])->first();

        if ($video)
        {
            $video->Data = json_encode($item);
            $video->write();
        }
        else
        {
            if ($type == 'video')
            {
                $date = Carbon::parse($item['snippet']['publishedAt']);
            }

            $video = new YoutubeVideo;
            $video->VideoID = $item['id']['videoId'];
            $video->PublishDate = $date->format('Y-m-d H:i:s');
            $video->Data = json_encode($item);
            $video->write();
        }
    }

    private function returnSuccess($data = null, $code = 200)
    {
        print_r([
            'error' => false,
            'status_code' => $code,
            'data' => $data
        ]);
    }

    private function returnFailed($message = null, $code = 500)
    {
        if($message instanceof Response)
        {
            $message = json_decode($message->getBody()->getContents())->error->message;
            $code = 403;
        }
        else if(is_object($message))
        {
            $code = $message->status();
        }

        print_r([
            'error' => true,
            'status_code' => $code,
            'message' => ($message) ? $message['error']['message'] ?? $message : 'Unexpected error occurred'
        ]);
    }
}
