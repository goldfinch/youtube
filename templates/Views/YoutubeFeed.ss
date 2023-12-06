<% if YoutubeVideos($limit) %>
  <div class="container">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
      <% loop YoutubeVideos($limit) %>
        <div class="col">
          <div class="card">
1
            <%-- <img src="{$Data.postImage}" height="250" style="object-fit: cover" class="card-img-top" alt="$Data.postText.LimitCharacters(32)">
            <div class="card-body">
              <div><b>Link:</b> <a href="$Data.postLink" rel="noreferrer noopener" target="_blank">$Data.postLink</a></div>
              <div><b>Date:</b> $Data.postDate(Y-m-d H:i:s)</div>
              <div><b>Date ago:</b> $Data.postDateAgo</div>
              <div><b>Text:</b> $Data.postText.LimitCharacters(100)</div>
              <div><b>Shares:</b> $Data.postCounter(shares)</div>
              <div><b>Likes:</b> $Data.postCounter(likes)</div>
              <div><b>Comments:</b> $Data.postCounter(comments)</div>
              <div><b>Type:</b> $Data.postType</div>
            </div> --%>

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
