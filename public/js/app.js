
function addEventListeners() {

  let bidCreators = document.querySelectorAll('#auction_page form.new_bid');
  [].forEach.call(bidCreators, function(creator) {
    creator.addEventListener('submit', sendCreateBidRequest);
  });

  let auctionDeleters = document.querySelectorAll('#auction_page header a.delete');
  [].forEach.call(auctionDeleters, function(deleter) {
    deleter.addEventListener('click', sendDeleteAuctionRequest);
  });

  let profileDeleters = document.querySelectorAll('article.profile header a.delete');
  [].forEach.call(auctionDeleters, function(deleter) {
    deleter.addEventListener('click', sendDeleteProfileRequest);
  });

  let profileUpdater = document.querySelector('article.edit_profile form.update_profile');
  if (profileUpdater != null)
    profileUpdater.addEventListener('submit', sendUpdateProfileRequest);

  let auctionUpdater = document.querySelector('article.edit_auction form.update_auction');
  if (auctionUpdater != null)
    auctionUpdater.addEventListener('submit', sendUpdateAuctionRequest);

  let followUser = document.querySelector('article.profile header h2 a#follow');
  if (followUser != null)
    followUser.addEventListener('click', sendFollowUserRequest);

  let unfollowUser = document.querySelector('article.profile header h2 a#following');
  if (unfollowUser != null)
    unfollowUser.addEventListener('click', sendUnfollowUserRequest);

  let followAuction = document.querySelector('article.auction_page header h2 a#follow');
  if (followAuction != null)
  followAuction.addEventListener('click', sendFollowAuctionRequest);

  let unfollowAuction = document.querySelector('article.auction_page header h2 a#following');
  if (unfollowAuction != null)
  unfollowAuction.addEventListener('click', sendUnfollowAuctionRequest);

  let commentCreator = document.querySelector('#auction_page form.new_comment');
  if (commentCreator != null)
  commentCreator.addEventListener('submit', sendCommentCreateRequest);

  let notifCheckers = document.querySelectorAll('section#notifications li.notification input[type=checkbox]');
  [].forEach.call(notifCheckers, function(checker) {
    checker.addEventListener('change', sendCheckNotificationRequest);
  });

  let checkAll = document.querySelector('section#notifications input[type=checkbox]');
  if (checkAll != null)
  checkAll.addEventListener('change', sendCheckAllRequest);

  let adminRequestCheckers = document.querySelectorAll('section#admin_requests li.admin_requests input[type=checkbox]');
  [].forEach.call(adminRequestCheckers, function(checker) {
    checker.addEventListener('change', sendCheckAdminReqRequest);
  });
}

function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

function sendCreateBidRequest(event) {
  let id = this.closest('section').getAttribute('data-id');
  let bid_value = this.querySelector('input[name=bid_value]').value;

  if (bid_value != null)
    sendAjaxRequest('put', '/api/auctions/' + id, {bid_value: bid_value}, bidAddedHandler);

  event.preventDefault();
}

function sendDeleteAuctionRequest(event) {
  let id = this.closest('article').getAttribute('data-id');

  sendAjaxRequest('delete', '/api/auctions/' + id, null, auctionDeletedHandler);
}

function sendDeleteProfileRequest(event) {
  let id = this.closest('article').getAttribute('data-id');

  sendAjaxRequest('delete', '/api/profile/' + id, null, profileDeletedHandler);
}

function sendUpdateAuctionRequest(event) {
  let id = this.closest('article').getAttribute('data-id');

  let name = this.querySelector('input[name=name]').value;
  let description = this.querySelector('input[name=description]').value;

  if (name != '' || description != '')
    sendAjaxRequest('put', 'edit/update', {name: name, description: description}, auctionUpdatedHandler);
    
    event.preventDefault();
 }

function sendUpdateProfileRequest(event) {
  let id = this.closest('article').getAttribute('data-id');

  let name = this.querySelector('input[name=name]').value;
  let email = this.querySelector('input[name=email]').value;
  let about = this.querySelector('input[name=about]').value;

  if (name != '' || email != '' || about != '')
    sendAjaxRequest('put', 'edit/update', {name: name, email: email, about: about}, profileUpdatedHandler);
    
    event.preventDefault();
}

function sendFollowUserRequest(event) {
  let id = this.closest('article').getAttribute('data-id');
  console.log(id);
  sendAjaxRequest('put', id+'/follow', null, followedUserHandler);
}

function sendUnfollowUserRequest(event) {
  let id = this.closest('article').getAttribute('data-id');
  console.log(id);
  sendAjaxRequest('delete', id+'/unfollow', null, unfollowedUserHandler);
}

function sendFollowAuctionRequest(event) {
  let id = this.closest('article').getAttribute('data-id');
  console.log(id);
  sendAjaxRequest('put', id+'/follow', null, followedAuctionHandler);
}

function sendUnfollowAuctionRequest(event) {
  let id = this.closest('article').getAttribute('data-id');
  console.log(id);
  sendAjaxRequest('delete', id+'/unfollow', null, unfollowedAuctionHandler);
}

function sendCommentCreateRequest(event){
  let id = this.closest('article').getAttribute('data-id');
  let comment = this.querySelector('input[name=comment]').value;
  sendAjaxRequest('put', id+'/new_comment', {comment:comment}, commentCreatedHandler);

}

function sendCheckNotificationRequest(event){
  let notif = this.closest('li');
  let not_id = notif.getAttribute('data-id');
  let user_id = this.closest('article').getAttribute('data-id');

  let checked = notif.querySelector('input[type=checkbox]').checked;

  sendAjaxRequest('put', '/profile/'+user_id+'/notifications/', {seen:checked, not_id:not_id}, notificationCheckedHandler);
}

function sendCheckAllRequest(event){
  let notif = this.closest('section');
  let user_id = notif.getAttribute('data-id');

  sendAjaxRequest('put', '/profile/'+user_id+'/notifications/check', null, checkAllHandler);
}

function sendCheckAdminReqRequest(event){
  let req = this.closest('li');
  let req_id = req.getAttribute('data-id');
  let user_id = this.closest('article').getAttribute('data-id');
  console.log(req_id);
  console.log(user_id);

  let checked = req.querySelector('input[type=checkbox]').checked;

  sendAjaxRequest('put', '/admin/'+user_id+'/requests/', {seen:checked, req_id:req_id}, adminReqCheckedHandler);
}

function bidAddedHandler() {
  if (this.status != 200) window.location = '/';
  let bid = JSON.parse(this.responseText);
  window.location = '/auctions/' +bid.auction_id;
}

function auctionDeletedHandler() {
  if (this.status != 200) window.location = '/';
  let auction = JSON.parse(this.responseText);
  let article = document.querySelector('article.auction_page[data-id="'+ auction.id + '"]');
  article.remove();
}

function profileDeletedHandler() {
  if (this.status != 200) window.location = '/';
  let profile = JSON.parse(this.responseText);
  let article = document.querySelector('article.profile[data-id="'+ profile.id + '"]');
  article.remove();
}

function profileUpdatedHandler(){
  if (this.status != 200) window.location = '/';
  let res = JSON.parse(this.responseText);
  window.location = '/profile/'+res.id;
}

function auctionUpdatedHandler(){
  if (this.status != 200) window.location = '/auctions';
  let res = JSON.parse(this.responseText);
  window.location = '/auctions/'+res.id;
}

function followedUserHandler(){
  if (this.status != 201) window.location = '/';
  let res = JSON.parse(this.responseText);
  window.location = '/profile/'+res.followed_id;
}

function unfollowedUserHandler(){
  if (this.status != 201) window.location = '/';
  let res = JSON.parse(this.responseText);
  window.location = '/profile/'+res.followed_id;
}

function followedAuctionHandler(){
  if (this.status != 201) window.location = '/';
  let res = JSON.parse(this.responseText);
  window.location = '/auctions/'+res.auction_id;
}

function unfollowedAuctionHandler(){
  if (this.status != 201) window.location = '/';
  let res = JSON.parse(this.responseText);
  window.location = '/auctions/'+res.auction_id;
}

function commentCreatedHandler(){
  if (this.status != 200) window.location = '/';
  console.log(this.responseText);
  let res = JSON.parse(this.responseText);
  window.location = '/auctions/'+res.auction_id;
}

function notificationCheckedHandler(){
  if (this.status != 200) window.location = '/';
  console.log(this.responseText);
  let res = JSON.parse(this.responseText);
  window.location = '/profile/'+res.user_id+'/notifications';
}

function checkAllHandler(){
  if (this.status != 200) window.location = '/';
  console.log(this.responseText);
  let res = JSON.parse(this.responseText);
  window.location = '/profile/'+res.id+'/notifications';
}

function adminReqCheckedHandler(){
  if (this.status != 200) window.location = '/';
  console.log(this.responseText);
  let res = JSON.parse(this.responseText);
  window.location = '/admin/'+res.admin_id+'/requests';
}

addEventListeners();
