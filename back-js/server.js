const express = require("express");
const { extend } = require("jquery");

const app = express();
const port = 5000;

app.use("/post", require("./routes/post.routes"))

app.use(express.json())
app.use(express.urlencoded({ extended: false}))

app.listen(port, () => console.log(" Connexion a MongoDB, réussie au port" + port))


