$(document).ready(function () {
   //navbar animation on scroll
   $(window).on('scroll', function () {
      var navmenu = $('#navbar');
      if ($(window).scrollTop() < 30) {
         navmenu.removeClass("bg-white shadow-sm");
         navmenu.addClass('mt-3');
      } else {
         navmenu.removeClass('mt-3');
         navmenu.addClass('bg-white shadow-sm');
      }
   });

   //Enable Tooltip Everywhere
   $('[data-toggle="tooltip"]').tooltip();

   //Activate the tagging plugin
   $('[data-role="tags-input"]').tagsInput();

   //Store posts on profiles
   $('.storPosts').click(function (e) {
      var storPosts = $(this).attr('id'),
         id_Users = $(this).attr('title');
      $('#postStore').load('includes/storePosts.inc.php', {
         storPosts: storPosts,
         id_Users: id_Users
      }, function () {
         //if user likes a post
         $('.like').click(function () {
            $(this).next().load('includes/likeUnlikePost.inc.php', {
               liked: 1,
               id_Post: $(this).attr('id')
            });
            $(this).children('i').toggleClass('text-danger');
            var title = $(this).attr('data-original-title') == 'Unlove' ? 'Love' : 'Unlove';
            $(this).attr('data-original-title', title);
         });

         //if user Unlikes a post
         $('.unlike').click(function () {
            $(this).next().load('includes/likeUnlikePost.inc.php', {
               unliked: 1,
               id_Post: $(this).attr('id')
            });
            $(this).children('i').toggleClass('text-dark');
            var title = $(this).attr('data-original-title') == 'Unlove' ? 'Love' : 'Unlove';
            $(this).attr('data-original-title', title);
         });

         //Delete a post
         $('.deletePost').click(function () {
            let deleteConfirm = confirm('Are you sure you want to delete this post ?');
            if (deleteConfirm === true) {
               let article = $(this).parents('article');
               let id_Post = $(this).attr('id');
               $.ajax({
                  url: 'includes/deletePost.inc.php',
                  type: 'post',
                  async: true,
                  data: {
                     'id_Post': id_Post
                  },
                  success: function () {
                     article.remove();
                  },
                  error: function () {
                     alert('There is something wrrong, try again...');
                  }
               });
            }
         });
      });
   });

   //likes post button
   $('.like').click(function () {
      $(this).next().load('includes/likeUnlikePost.inc.php', {
         liked: 1,
         id_Post: $(this).attr('id')
      });
      $(this).children('i').toggleClass('text-danger');
      var title = $(this).attr('data-original-title') == 'Unlove' ? 'Love' : 'Unlove';
      $(this).attr('data-original-title', title);
   });

   //Unlikes post button
   $('.unlike').click(function () {
      $(this).next().load('includes/likeUnlikePost.inc.php', {
         unliked: 1,
         id_Post: $(this).attr('id')
      });
      $(this).children('i').toggleClass('text-dark');
      var title = $(this).attr('data-original-title') == 'Unlove' ? 'Love' : 'Unlove';
      $(this).attr('data-original-title', title);
   });

   //Delete a post
   $('.deletePost').click(function () {
      var deleteConfirm = confirm('Are you sure you want to delete this post ?');
      if (deleteConfirm === true) {
         var article = $(this).parents('article');
         var id_Post = $(this).attr('id');
         $.ajax({
            url: 'includes/deletePost.inc.php',
            type: 'post',
            async: true,
            data: {
               'id_Post': id_Post
            },
            success: function () {
               article.remove();
            },
            error: function () {
               alert('There is something wrrong, try again...');
            }
         });
      }
   });

   //check if input file is set and display file path on its label on uploading a post
   $('#uploadPost').change(function () {
      $('#fileLabelText').text($(this).val());
   });

   //Drag & Drop post to upload
   $('.uploadPost').on('dragover', function () {
      $(this).addClass('uploadPostDrag');
      return false;
   });
   $('.uploadPost').on('dragleave', function () {
      $(this).removeClass('uploadPostDrag');
      return false;
   });
   $('.uploadPost').on('drop', function (e) {
      e.preventDefault();
      $(this).removeClass('uploadPostDrag');
      var files_list = e.originalEvent.dataTransfer.files;
      if (files_list.length === 1) $(this).find('#uploadPost').prop('files', files_list);
      else $('#fileLabelText').text('You have to select just one photo');
   });

   //search for a post while typing
   $('.search').keyup(function () {
      //Replace spaces with empty field
      var value = $(this).val().replace(/^\s+/g, '').replace(/\s+$/g, '');
      //Get posts
      $('#posts').children('.row').load('includes/searchPost.inc.php', {
         value: value
      });
   });

   // Get Notifications from database every 5 seconds
   setInterval(function () {
      $.ajax({
         url: 'includes/notifications.inc.php',
         type: 'post',
         async: true,
         data: {
            'load': 1
         },
         success: function (data) {
            if (data > 0) {
               $('#notification-icon').append('<span class="badge d-inline-block bg-main small" id="nbr-notification">' + data + '</span>');
               $('title').text('(' + data + ') Notifications');
            }
         }
      });
   }, 5000);

   $('#notification-icon').click(function () {
      $('#notification-dropdown').children('div').remove();
      $('#nbr-notification').remove();
      $.ajax({
         url: 'includes/notifications.inc.php',
         type: 'post',
         async: true,
         data: {
            'clicked': 1
         },
         success: function (data) {
            $('#notification-dropdown').prepend(data);
         }
      });
   });

   // let limit = 4;
   // $('#loadPosts').click(function(){
   //
   //     limit += 4;
   //      $.ajax({
   //          url: 'loadPosts.php',
   //          type: 'post',
   //          async: true,
   //          data: {
   //              'limit': limit
   //          },
   //          success: function(data){
   //              $('#posts .row').append(data);
   //          }
   //      });
   // });
});