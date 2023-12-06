<% if ContentType == 'videos' %>
  $YoutubeService.YoutubeFeed($FeedLimit)
  <% else_if ContentType == 'channel_info' %>
  <%-- $Youtube.ChannelInfo($FeedLimit) --%>
  <% end_if %>
