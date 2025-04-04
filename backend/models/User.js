// models/User.js
import mongoose from 'mongoose';

const userSchema = new mongoose.Schema({
    _id: { type: String, required: true }, // Assuming _id is a string
    hostname: { type: String, required: true },
    startTime: { type: Date, required: true },
    startTimeLocal: { type: String, required: true },
    cmdLine: { type: Object, required: true },
    pid: { type: Number, required: true },
    buildinfo: { type: Object } // Optional field
});

const User = mongoose.model('User ', userSchema);
export default User;