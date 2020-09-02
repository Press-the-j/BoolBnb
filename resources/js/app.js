require("./bootstrap");
// require("dotenv").config();
// const fs = require("fs");

var map = tt.map({
    key: process.env.TOMTOM_API_KEY,
    container: "map",
    style: "tomtom://vector/1/basic-main",
    center: [-0.12634, 51.50276],
    zoom: 13
});

console.log(process.env);
