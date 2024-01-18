<% if ContentType == 'videos' %>
  $YoutubeService.YoutubeFeed($FeedLimit)
<% else_if ContentType == 'channel_info' %>
  $YoutubeService.YoutubeChannel
<% end_if %>
