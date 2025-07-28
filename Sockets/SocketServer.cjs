const httpServer = require('http').createServer();
const { Server } = require('socket.io');
const Redis = require('ioredis');

const io = new Server(httpServer, { cors: { origin: '*' } });
const redis = new Redis({
    host: '192.168.85.140',
    port: 6379,
});

redis.psubscribe('laravel_database_private-App.Models.AdminProfile.*');
redis.on('pmessage', (pattern, channel, message) => {

    const parsed = JSON.parse(message);
    io.emit(parsed.event, parsed.data);
    console.log(`message: ${parsed}`);
});

io.on('connection', socket => {
    console.log(`Client connected: ${socket.id}`);

    socket.on('disconnect', () => {
        console.log(`Client disconnected: ${socket.id}`);
    });
});

httpServer.listen(3000, () => {
    console.log('Socket server listening on port 3000');
});
