import mongoose from 'mongoose';

// Connect to MongoDB
mongoose.connect('mongodb://localhost:27017/mydatabase', {
    useNewUrlParser: true,
    useUnifiedTopology: true,
})
.then(() => {
    console.log('MongoDB connected');

    // Define the User schema
    const userSchema = new mongoose.Schema({
        _id: { type: String, required: true },
        hostname: { type: String, required: true },
        startTime: { type: Date, required: true },
        startTimeLocal: { type: String, required: true },
        cmdLine: { type: Object, required: true },
        pid: { type: Number, required: true },
        buildinfo: { type: Object } // Optional field
    });

    const User = mongoose.model('User ', userSchema);

    // Insert the user document
    User.create({
        _id: "Champion-1743004066498",
        hostname: "Champion",
        startTime: new Date("2025-03-26T15:47:46.000Z"),
        startTimeLocal: "Thu Mar 27 02:17:46.498",
        cmdLine: {
            config: "C:\\Program Files\\MongoDB\\Server\\8.0\\bin\\mongod.cfg",
            net: {
                bindIp: "127.0.0.1",
                port: 27017
            },
            service: true,
            storage: {
                dbPath: "C:\\Program Files\\MongoDB\\Server\\8.0\\data"
            },
            systemLog: {
                destination: "file",
                logAppend: true,
                path: "C:\\Program Files\\MongoDB\\Server\\8.0\\log\\mongod.log"
            }
        },
        pid: 10320,
        buildinfo: {
            version: "8.0.6",
            gitVersion: "80f21521ad4a3dfd5613f5d649d7058c6d46277f",
            targetMinOS: "Windows 7/Windows Server 2008 R2",
            modules: [],
            allocator: "tcmalloc-gperf",
            javascriptEngine: "mozjs",
            versionArray: [8, 0, 6, 0],
            bits: 64,
            debug: false,
            maxBsonObjectSize: 16777216,
            storageEngines: ["devnull", "wiredTiger"]
        }
    })
    .then(() => {
        console.log('User  inserted successfully');
        mongoose.connection.close(); // Close the connection
    })
    .catch(err => {
        console.error('Error inserting user:', err);
        mongoose.connection.close(); // Close the connection
    });
})
.catch(err => console.error('MongoDB connection error:', err));