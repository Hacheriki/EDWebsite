const express = require('express')
const session = require('express-session');
const path = require('path')
const apiRouter = require("./api");

const app = express()

let secret = 'qwerty';
app.use(session({
    secret: secret,
    resave: false,
    saveUninitialized: false
}));


app.set('view engine', 'ejs');
app.use(express.static(path.join(__dirname, 'public')))
app.use(express.json())
app.use(express.urlencoded({extended: true}))


app.use('/api',apiRouter)

app.get('/', (req, res) => {
    res.render('index', {user: req.session.user})
})

app.get('/item', (req, res) => {
    res.render('item', {user: req.session.user})
})

app.get('/cart', (req, res) => {
    res.render('cart', {user: req.session.user})
})
//TODO: DELETE ITEM

app.get('/categories', (req, res) => {
    res.render('categories', {user: req.session.user})
})

app.use(function(req, res, next) {
    res.status(404);

    if (req.accepts('html')) {
        res.render('404', { url: req.url, user: req.session.user });
        return;
    }

    if (req.accepts('json')) {
        res.json({ error: 'Not found' });
        return;
    }

    res.type('txt').send('Not found');
});


// TODO: Feedback, auth?
app.listen(3000, () => {
    console.log("Listening on port 3000!")
})

