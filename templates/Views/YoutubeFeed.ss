<% if YoutubeVideos($limit) %>
  <div class="container">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
      <% loop YoutubeVideos($limit) %>
        <div class="col">
          <div class="card">
            <img src="{$Data.videoImage(medium)}" height="250" style="object-fit: cover" class="card-img-top" alt="$Data.videoData.snippet.title">
            <div class="card-body">
              <div><b>Link:</b> <a href="$Data.videoLink" rel="noreferrer noopener" target="_blank">$Data.videoLink</a></div>
              <div><b>Date:</b> $Data.videoDate(Y-m-d H:i:s)</div>
              <div><b>Date ago:</b> $Data.videoDateAgo</div>
              <div><b>Title:</b> $Data.videoData.snippet.title</div>
              <div><b>Description:</b> $Data.videoData.snippet.description.LimitCharacters(100)</div>
            </div>

          </div>
        </div>
      <% end_loop %>
    </div>
  </div>
<% else %>
  <div class="container">
    <p>There are no YouTube videos</p>
  </div>
<% end_if %>
