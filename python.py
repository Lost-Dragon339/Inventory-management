from flask import Flask, render_template, request, redirect, url_for
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///products.db'
db = SQLAlchemy(app)

class Product(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    product_name = db.Column(db.String(100), nullable=False)
    product_price = db.Column(db.Float, nullable=False)
    manufacturer = db.Column(db.String(100), nullable=False)
    expiry_date = db.Column(db.Date, nullable=False)
    product_type = db.Column(db.String(50), nullable=False)
    location = db.Column(db.String(50), nullable=False)

@app.route('/')
def index():
    products = Product.query.all()
    return render_template('index.html', products=products)

@app.route('/add-product', methods=['GET', 'POST'])
def add_product():
    if request.method == 'POST':
        product_name = request.form['product_name']
        product_price = request.form['product_price']
        manufacturer = request.form['manufacturer']
        expiry_date = request.form['expiry_date']
        product_type = request.form['product_type']
        location = request.form['location']

        new_product = Product(product_name=product_name, product_price=product_price, manufacturer=manufacturer, expiry_date=expiry_date, product_type=product_type, location=location)
        db.session.add(new_product)
        db.session.commit()

        return redirect(url_for('index'))

    return render_template('add-product.html')

@app.route('/edit-product/<int:product_id>', methods=['GET', 'POST'])
def edit_product(product_id):
    product = Product.query.get_or_404(product_id)

    if request.method == 'POST':
        product.product_name = request.form['product_name']
        product.product_price = request.form['product_price']
        product.manufacturer = request.form['manufacturer']
        product.expiry_date = request.form['expiry_date']
        product.product_type = request.form['product_type']
        product.location = request.form['location']

        db.session.commit()

        return redirect(url_for('index'))

    return render_template('edit-product.html', product=product)

@app.route('/delete-product/<int:product_id>')
def delete_product(product_id):
    product = Product.query.get_or_404(product_id)
    db.session.delete(product)
    db.session.commit()

    return redirect(url_for('index'))

if __name__ == '__main__':
    app.run(debug=True)
