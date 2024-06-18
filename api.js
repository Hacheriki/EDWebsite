const express = require('express');
const apiRouter = express.Router();


const connection = require('./db')
const {response} = require("express");

apiRouter.get('/getUserLinks/:id', (req, res) => {
    connection.query("SELECT * FROM links WHERE userId = ?",
        [req.params.id], (err, result) => {
            if (err) {
                res.status(500).send(err)
            }

            res.render('template', {page: 'home', user: req.session.user, urls: result})
        })
})

apiRouter.get('/getFeaturedProducts', (req, res) => {
    connection.query("SELECT * FROM products WHERE is_featured = 1 AND quantity > 0", (err, result) => {
        res.status(200).send(result)
    })
})

apiRouter.get('/getItem', (req, res) => {
    connection.query("SELECT * FROM products WHERE product_id = ?", [req.query.id], (err, result) => {
        res.status(200).send(result[0])
    })
})

apiRouter.post('/addToCart', (req, res) => {
    console.log(req.body)
    if (!req.session.cart) {
        req.session.cart = []
    }
    req.session.cart.push(req.body)
    res.status(200).send({
        "response": "Товар успешно добавлен в корзину"
    })
})

apiRouter.get('/getCart', (req, res) => {
    if (!req.session.cart) {
        res.status(200).send([])
        return;
    }

    connection.query("SELECT product_id, name, price FROM products", (err, result) => {
        console.log(err)
        let productDetails = []
        let totalPrice = 0
        result = result.reduce((acc, item) => {
            acc[item.product_id] = item
            return acc
        }, {})
        for (let cartItem of req.session.cart) {
            const singleProductDetails = {...result[cartItem.product_id]}
            singleProductDetails.totalItemPrice = result[cartItem.product_id]["price"] * cartItem.quantity
            singleProductDetails.quantity = cartItem.quantity

            totalPrice += singleProductDetails.totalItemPrice
            productDetails.push(singleProductDetails)
        }
        res.status(200).send({
            products: productDetails,
            totalPrice
        })
    })
})

async function checkAndUpdateQuantity(productId, quantityNeeded) {
    return await new Promise((resolve, reject) => {
        connection.query("SELECT quantity FROM products WHERE product_id = ?", [productId], (err, result) => {
            const row = result[0]
            if (row['quantity'] >= quantityNeeded) {
                let newQuantity = row['quantity'] - quantityNeeded
                connection.query("UPDATE products SET quantity = ? WHERE product_id = ?", [newQuantity, productId])
                resolve(true)
            } else {
                resolve(false)
            }
        })
    })
}

apiRouter.post('/processOrder', async (req, res) => {
    if (!req.session.cart) {
        res.status(400).send({
            "response": "Корзина пуста"
        })
        return
    }

    let allProductsAvailable = true;
    for (let cartItem of req.session.cart) {
        if (!await checkAndUpdateQuantity(cartItem.product_id, cartItem.quantity)) {
            allProductsAvailable = false
            break
        }
    }

    if (!allProductsAvailable) {
        res.status(400).send({response: "Извините, один из товаров закончился"})
        return
    }

    const productIds = JSON.stringify(req.session.cart.map((item) => {
        return +item.product_id
    }));
    const productCounts = JSON.stringify(req.session.cart.map((item) => {
        return +item.quantity
    }));
    const totalPrice = req.body.total_price;
    const clientPhone = req.body.client_phone;
    console.log(req.body)

    connection.query("INSERT INTO orders (product_ids, overall_price, client_phone, product_counts) VALUES (?, ?, ?, ?)", [productIds, totalPrice, clientPhone, productCounts], (err, result) => {
        res.status(200).send({
            response: "Заказ успешно создан! Номер вашего заказа: " + result.insertId
        })
    })
})

apiRouter.get("/filterItems", (req,res) => {

    let category = "";
    let maxPrice = "";

    if (req.query.category) {
        category = req.query.category
    }

    if (req.query.maxPrice) {
        maxPrice = req.query.maxPrice
    }

    let sql = "SELECT p.product_id, p.name, p.price, p.image_url FROM products p WHERE p.quantity > 0 ";
    if (category || maxPrice) {
        sql += "AND ";
        const conditions = [];

        if (category) {
            conditions.push("p.category_id = ?");
        }

        if (maxPrice) {
            conditions.push("p.price <= ?");
        }

        sql += conditions.join(" AND ");
    }

    let params = []
    if (category && maxPrice) {
        params = [category, maxPrice]
    } else if (category) {
        params = [category]
    } else if (maxPrice) {
        params = [maxPrice]
    }

    connection.query(sql, params, (err, result) => {
        console.log(err)
        res.status(200).send(result)
    })
})

apiRouter.get('/getCategories', (req, res) => {
    connection.query("SELECT * FROM categories", (err, result) => {
        res.status(200).send(result)
    })
})

module.exports = apiRouter