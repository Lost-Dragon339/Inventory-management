const mysql = require('mysql');

const connection = mysql.createConnection({
    host: 'localhost',
    user: 'username',
    password: 'password',
    database: 'mydb'
});

connection.connect((err) => {
    if (err) throw err;
    console.log('Connected to MySQL database');
});

// Execute SQL queries using the connection object
connection.query('SELECT * FROM products', (err, results) => {
    if (err) throw err;
    console.log(results);
});
