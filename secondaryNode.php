<!DOCTYPE html>
<html>
	<head>
		<!--RabbitMQ connection -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="//cdn.jsdelivr.net/sockjs/1.0.3/sockjs.min.js"></script>
		<script src="stomp.js"></script>

		<script>
			var mainhost = "192.168.204.129";
			var localhost = "192.168.204.130";
			var name = 'Node2'; // name of itself
			var password = 'node2'; // name of itself
			var nodes = new Array(); //replica nodes
			

			function readNews(){
				$.ajax({
					type: 'POST',
					url: "http://"+localhost+"/table.php?TYPE=GET",
					complete: function(result){
						document.getElementById("txtNews").innerHTML = atob(result.responseText);
					}
				});
			}

			//Used for synchronizing news on replica nodes' database
			function syncNews(newsType,news){
				for (var i in nodes) {
					//nodea[i]['Name']
					$.ajax({
						type: 'POST',
						url: "http://"+nodea[i]['IPAddress']+"/table.php?TYPE=UPDATE&Type="+newsType+"&News="+news,
						complete: function(result){
							localLog('synchronized News to node: '+ nodea[i]['Name']);
						}
					});
					}
			}
			function localLog(Information){
				var Timestamp = new Date().getTime();
				$.ajax({
					type: 'POST',
					url: "http://"+nodea[i]['IPAddress']+"/log.php?TYPE=WRITE&Timestamp="+Timestamp+"&Information="+Information,
					complete: function(result){
						
					}
				});
				
			}
			//check whether its IP is in the main node's list
			function checkMainNodeIPList(){

				$.get("http://"+mainhost+"/nodes.php?TYPE=GET", function(result){
					var isThere = false;
					for(var x in result ){ //x is index, result[x] is the object
							if ( result[x]['IPAddress'] == localhost ) {
								isThere = true;
							}
					}
					if (!isThere){ //not found in the list
						$.ajax({
							type: 'POST',
							url: "http://"+mainhost+"/nodes.php?TYPE=POST&Name="+name+"&IPAddress="+localhost+"&Password="+password,
							complete: function(result){
								localLog("Cannot found IP in main nodes, add it.");
							}
						});
					}
				});
			}
			//Using RabbitMQ to send log information
			function globleLog(info){
				//RabbitMQ_send("log",info);
			}
			//Get nodes arrry which contain the IP address of the replicas
			function getNodesIP(){

				$.get("http://"+localhost+"/nodes.php?TYPE=GET", function(result){
					//alert(result);
					for(var x in result ){ //x is index, result[x] is the object
							nodes.push(result[x]);
							//alert(result[x]['Name']);
					}
				});
				
			}
			function updateNews(){
				
				var e = document.getElementById('newsType');
				var newsType = e.options[e.selectedIndex].value;


				$.ajax({
					type: 'POST',
					url: "http://"+localhost+"/table.php?TYPE=UPDATE&Type="+newsType+"&News="+news,
					complete: function(result){
						alert('Successed Added');
						readNews();
						syncNews(newsType,news);
						globleLog("Successfully add News on Main Node.");
					}
				});
			
			}
					 
			$(document).ready(function(){

				readNews();
				checkMainNodeIPList();
				//getNodesIP();

				//$(window).on('beforeunload', function(){
				//      socket.close();
				//});
				/*WebSocketStompMock = SockJS;
				var client, destination;
				var url = 'ws://127.0.0.1:15674/stomp/websocket';
				//var url = 'http://127.0.0.1:55674/stomp';
				var login = 'ds';
				var passcode = 'abcd1234';
				destination = '/exchange/distributedsystem';

				client = Stomp.client(url);

				//var ws = new WebSocket('ws://127.0.0.1:15674/ws');
				//var client = Stomp.over(ws);

				// this allows to display debug logs directly on the web page
				client.debug = function(str) {
					$("#debug").append(str + "\n");
				};
				// the client is notified when it is connected to the server.
				client.connect(login, passcode, function(frame) {
					client.subscribe(destination, function(message) {
						//call-back function after receive new message can process here
					});
				});
				function RabbitMQ_send(message_type,message){
					client.send(destination, {type:message_type}, message);
				};*/
									
			});

		</script>
	</head>
	<body>


		<!--
		News:<br>
		<input type="text" name="news" id="news" value="News">
		<br>
		News Type:<br>
		<select id="newsType">
			<option value="public">Public</option>
			<option value="private">Private</option>
		</select> 
		<br><br>
		<input type="button" value="Submit" onclick="updateNews()">
		-->
		Hi, This is Replica node.
		<br><br>
		<div id="txtNews"></div>
		
		<script>

		</script>
	</body>
</html>

