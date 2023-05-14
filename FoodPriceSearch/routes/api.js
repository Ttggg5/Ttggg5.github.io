var express = require('express');
var router = express.Router();

sqlite = require('sqlite3').verbose();
db = new sqlite.Database("./db.sqlite", sqlite.OPEN_READWRITE, (err) => {
    if (err) {
        console.error(err.message);
    }
    console.log('Connected to the database.');
});

router.post('/', (req, res) => {
    const {foodName, price, dateYear, dateMonth}=req.body;
    sql = "INSERT INTO food (name, price, date) VALUES (?, ?, ?)";
    db.run(sql, [foodName, price, dateYear + dateMonth], (err) => {
        if (err) {
            console.error(err.message);
            res.redirect("/home.html?message=Error!");
        }
        console.log('inserted');
        res.redirect("/home.html?message=Complete");
    });
})

router.get('/', function(req, res, next) {
    const date = req.query;
    console.log(date);
    sql= "SELECT * FROM food WHERE date >= ? AND date <= ?";
    db.all(sql, [date['startDate'], date['endDate']], (err, rows) => {
        if (err) {
            throw err;
        }
        res.send(rows);
    });
});

module.exports = router;