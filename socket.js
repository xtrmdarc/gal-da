var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

var channelsToSubscribe = [
    'pedido-registrado',
    'pedido-cancelado',
    'venta-efectuada'
];

redis.subscribe(channelsToSubscribe, function(message) {
    
});

redis.on('message', function(channel, message) {
    console.log('Message Recieved: ' + message);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

io.on('connection',function(socket){
    console.log('user connected');
});

http.listen(3000, function(){
    console.log('Listening on Port 3000');
});

/*const SOCKET_PORT = 3000;
const REDIS = {
    "host": "127.0.0.1",
    "port": "6379",
    "password": "redispassword",
    "family": 4
}
function handler(request, response) {
    response.writeHead(200);
    response.end('');
}
var app = require('http').createServer(handler);
var io = require('socket.io')(app);
var ioRedis = require('ioredis');
var redis = new ioRedis(REDIS);
app.listen(SOCKET_PORT, function() {
    console.log(new Date + ' - Server is running on port ' + SOCKET_PORT + ' and listening Redis on port ' + REDIS.port + '!');
});
io.on('connection', function(socket) {
    console.log('A client connected');
});
redis.psubscribe('*', function(err, count) {
    console.log('Subscribed');
});
redis.on('pmessage', function(subscribed, channel, data) {
    data = JSON.parse(data);
    console.log(new Date);
    console.log(data);
    io.emit(channel + ':' + data.event, data.data);
});*/

/*var app = require('http').createServer(handler);
var io = require('socket.io')(app);
var Redis = require('ioredis');
var redis = new Redis();

app.listen(6001, function() {
    console.log('Server is running!');
});

function handler(req, res) {
    res.writeHead(200);
    res.end('');
}

io.on('connection', function(socket) {});

redis.psubscribe('*', function(err, count) {});

redis.on('pmessage', function(subscribed, channel, message) {
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});
*/