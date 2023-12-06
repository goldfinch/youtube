<div class="container">
  <div class="row g-4">
    <div class="col-md-3">
      <img src="{$cfg.channelImage(medium)}" width="200" height="200" style="object-fit: cover" class="rounded" alt="$cfg.channelData.snippet.title(32)">
    </div>
    <div class="col-md-9">
      <h3>About channel</h3>
      <ul>
        <li>Title: $cfg.channelData.snippet.title</li>
        <li>Description: $cfg.channelData.snippet.description</li>
        <li>Custom url: <a href="$cfg.channelLink" target="_blank">$cfg.channelData.snippet.customUrl</a></li>
      </ul>
      <h4>Statistics</h4>
      <ul>
        <li>Views: $cfg.channelData.statistics.viewCount</li>
        <li>Subscribers: $cfg.channelData.statistics.subscriberCount</li>
        <li>Hidden subscribers: $cfg.channelData.statistics.hiddenSubscriberCount</li>
        <li>Videos: $cfg.channelData.statistics.videoCount</li>
      </ul>
      <h4>Branding Settings</h4>
      <ul>
        <li>Banner: $cfg.channelData.brandingSettings.image.bannerExternalUrl</li>
      </ul>
    </div>
  </div>
</div>
