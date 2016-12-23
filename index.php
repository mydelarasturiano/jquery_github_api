<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Github API</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script type="text/javascript">
		function requestJSON(url, callback) {
			$.ajax({
			  url: url,
			  complete: function(xhr) {
			    callback.call(null, xhr.responseJSON);
			  }
			});
		}

		$(function(){
			$('#ghsubmitbtnuserlist').on('click', function(e){
				e.preventDefault();
				$('#ghapidatauserlist').html('<div id="loader">Loading...</div>');
				
				var usernamelist = $('#ghusernamelist').val();
			    var requriuserlist   = 'https://api.github.com/search/users?q='+usernamelist;
			    requestJSON(requriuserlist, function(json) {
			    	if(json.message == "Not Found" || usernamelist == '') {
				        $('#ghapidatauserlist').html("<h2>No User Info Found</h2>");
				    }
		    		else {
		    			// else we have a list of user and we display the list
				        var username   = json.login;
				        var aviurl     = json.avatar_url;

	        			var username_list;
        				$.getJSON(requriuserlist, function(json){
          					username_list = json;   
          					outputPageContentUserList();                
        				});          

		        		function outputPageContentUserList() {

		        			var outhtml;
				         	if(username_list.length == 0) { 
				         		outhtml = '<p>No username!</p></div>'; 
				         	}
				         	else {
				            	outhtml = '<p><strong>List of usernames:</strong></p>';
				            	outhtml = outhtml + '<ul>';
				            	$.each(username_list.items, function(key,value) {
				            		outhtml = outhtml + '<div class="userlist clearfix">';
				            		outhtml = outhtml + '<li>';
				            		outhtml = outhtml + '<a href="https://jquerygithubapi.herokuapp.com//?username='+ value.login +'" target="_blank"><img src="'+ value.avatar_url +'" width="40" height="40" alt="'+ value.login +'"></a>';
				             		outhtml = outhtml + '<a href="https://jquerygithubapi.herokuapp.com//?username='+ value.login +'" target="_blank"><h2>'+ value.login + '</h2></a>';
				             		outhtml = outhtml + '</li>';
				            	});
				            	outhtml = outhtml + '</ul>';
				            	outhtml = outhtml + '</div>'; 
				        	}
				         	$('#ghapidatauserlist').html(outhtml);
				        } // end outputPageContent()
		    		}
			    })
			})
		})

		$(function(){
			$('#ghsubmitbtn').on('click', function(e){	
		    	e.preventDefault();
		   		$('#ghapidata').html('<div id="loader">Loading...</div>');
		    
			    var username = $('#ghusername').val();
			    var requri   = 'https://api.github.com/users/'+username;
			    var repouri  = 'https://api.github.com/users/'+username+'/repos';
		    
		    	requestJSON(requri, function(json) {

					if(json.message == "Not Found" || username == '') {
				        $('#ghapidata').html("<h2>No User Info Found</h2>");
				    }
		    		else {
				        // else we have a user and we display their info
				        var fullname   = json.name;
				        var username   = json.login;
				        var aviurl     = json.avatar_url;
				        var profileurl = json.html_url;
				        var location   = json.location;
				        var followersnum = json.followers;
				        var followingnum = json.following;
				        var reposnum     = json.public_repos;
	        
	        			if(fullname == undefined) { fullname = username; }

				        var outhtml = '<h2>'+fullname+' <span class="smallname">(@<a href="'+profileurl+'" target="_blank">'+username+'</a>)</span></h2>';
				        outhtml = outhtml + '<div class="ghcontent"><div class="avi"><a href="'+profileurl+'" target="_blank"><img src="'+aviurl+'" width="80" height="80" alt="'+username+'"></a></div>';
				        outhtml = outhtml + '<p>Followers: '+followersnum+' - Following: '+followingnum+'<br>Repos: '+reposnum+'</p></div>';
				        outhtml = outhtml + '<div class="repolist clearfix">';

	        			var repositories;
        				$.getJSON(repouri, function(json){
          					repositories = json;   
          					outputPageContent();                
        				});          
        
		        		function outputPageContent() {
				         	if(repositories.length == 0) { 
				         		outhtml = outhtml + '<p>No repos!</p></div>'; 
				         	}
				         	else {
				            	outhtml = outhtml + '<p><strong>Repos List:</strong></p> <ul>';
				            	$.each(repositories, function(index) {
				             		outhtml = outhtml + '<li><a href="'+repositories[index].html_url+'" target="_blank">'+repositories[index].name + '</a></li>';
				            	});
				            	outhtml = outhtml + '</ul></div>'; 
				        	}
				         	$('#ghapidata').html(outhtml);
				        } // end outputPageContent()
		      		} // end else statement
		    	}); // end requestJSON Ajax call
			}); // end click event handler
		});

		function githubApiData(ghusername){		    
			    var username = ghusername;
			    var requri   = 'https://api.github.com/users/'+username;
			    var repouri  = 'https://api.github.com/users/'+username+'/repos';
		    
		    	requestJSON(requri, function(json) {

					if(json.message == "Not Found" || username == '') {
				        $('#ghapidatauserinfo').html("<h2>No User Info Found</h2>");
				    }
		    		else {
				        // else we have a user and we display their info
				        var fullname   = json.name;
				        var username   = json.login;
				        var aviurl     = json.avatar_url;
				        var profileurl = json.html_url;
				        var location   = json.location;
				        var followersnum = json.followers;
				        var followingnum = json.following;
				        var reposnum     = json.public_repos;
	        
	        			if(fullname == undefined) { fullname = username; }

				        var outhtml = '<h2>'+fullname+' <span class="smallname">(@<a href="'+profileurl+'" target="_blank">'+username+'</a>)</span></h2>';
				        outhtml = outhtml + '<div class="ghcontent"><div class="avi"><a href="'+profileurl+'" target="_blank"><img src="'+aviurl+'" width="80" height="80" alt="'+username+'"></a></div>';
				        outhtml = outhtml + '<p>Followers: '+followersnum+' - Following: '+followingnum+'<br>Repos: '+reposnum+'</p></div>';
				        outhtml = outhtml + '<div class="repolist clearfix">';

	        			var repositories;
        				$.getJSON(repouri, function(json){
          					repositories = json;   
          					outputPageContent();                
        				});          
        
		        		function outputPageContent() {
				         	if(repositories.length == 0) { 
				         		outhtml = outhtml + '<p>No repos!</p></div>'; 
				         	}
				         	else {
				            	outhtml = outhtml + '<p><strong>Repos List:</strong></p> <ul>';
				            	$.each(repositories, function(index) {
				             		outhtml = outhtml + '<li><a href="'+repositories[index].html_url+'" target="_blank">'+repositories[index].name + '</a></li>';
				            	});
				            	outhtml = outhtml + '</ul></div>'; 
				        	}
				         	$('#ghapidatauserinfo').html(outhtml);
				        } // end outputPageContent()
		      		} // end else statement
		    	}); // end requestJSON Ajax call
		}
	</script>
</head>
<body>
	<div id="w">
		<?php
		if(isset($_GET['username'])){
		?>
			<div id="ghapidatauserinfo" class="clearfix"></div>
			<script type="text/javascript">
				window.onload=githubApiData('<?php echo $_GET["username"];?>');
			</script>
		<?php
		}
		else{
		?>
			<b>Developer:</b> Mydel-Ar A. Asturiano
			<h1>Github API Webapp</h1>
			<p>Enter a Github username below and click the button to display list of Github username.</p>
			
			<input type="text" name="ghusernamelist" id="ghusernamelist" placeholder="Github username list...">
			<a href="#" id="ghsubmitbtnuserlist">Pull User List</a>
			<div id="ghapidatauserlist" class="clearfix"></div>
		<?php
		}
		?>
	</div>
</body>
</html>