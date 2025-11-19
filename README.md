# OroCommerce PDP Stock Display Customization

This repository is an **OroCommerce Community Edition 6.1** demo application with a focused customization:

- A custom bundle (`AcmeStockPdpBundle`) that **overrides the stock label on the Product Detail Page (PDP)**.
- Stock is retrieved programmatically and displayed with clearer messages (e.g. **“Low stock”**, **“In stock – contact seller”**, **“Out of stock”**).
- All changes are implemented inside an **isolated bundle**, without modifying Oro core files.

This repository is the final delivery for the PDP stock display challenge.

---

The stock value is retrieved inside an isolated Symfony bundle, `AcmeStockPdpBundle`. A dedicated service (`StockProvider`) uses Doctrine and Oro’s existing inventory entities to obtain the current inventory quantity for the PDP product. The bundle is registered via `bundles.yml` and its services via `services.yml`.

On the presentation side, a layout update (`product_view_stock.yml`) hooks into the existing `product_view_brand_inventory_status` block on the product view layout. This update sets a custom block theme (`stock_info.html.twig`) and passes both the current product and the computed stock data to that Twig template. The template then applies simple business rules (low inventory threshold, zero-quantity “contact seller” case, normal/out-of-stock) to choose the final label and CSS state class, reusing Oro’s standard status-label styles so the customization blends into the default storefront theme.


---

## 1. Requirements

Tested with:

- PHP ≥ 8.4  
- Composer ≥ 2.x  
- Docker & Docker Compose (PostgreSQL, Redis, Mailcatcher)  
- Node / npm (optional, only if you want to rebuild frontend assets)

The PHP application runs directly on the host (for example WSL2 / Linux). Docker is used only for infrastructure services.

---

## 2. Setup & Installation (Development Mode)

### 2.1 Clone the repository

    git clone https://github.com/Felipeleut/orocommerce-application-demo.git
    cd orocommerce-application-demo

### 2.2 Configure environment

Copy the default app environment file:

    cp .env-app .env-app.local

If necessary, edit `.env-app.local` and adjust the database section.  

### 2.3 Start Docker services

From the project root:

    docker compose up -d
    # or: docker-compose up -d

This starts:

- `pgsql` – PostgreSQL 13.x  
- `redis` – Redis cache  
- `mailcatcher` – SMTP testing (optional)

### 2.4 Install PHP dependencies

    composer install

### 2.5 Install OroCommerce (dev, with sample data)

Run the installer in development mode and load the demo data:

    php bin/console oro:install \
      --env=dev \
      --timeout=600 \
      --language=en \
      --formatting-code=en_US \
      --organization-name="AAXIS Test" \
      --user-name=admin \
      --user-email=admin@example.com \
      --user-firstname=Admin \
      --user-lastname=User \
      --user-password=admin \
      --application-url="http://localhost:8000" \
      --sample-data=y

This will:

- Create and migrate the PostgreSQL database  
- Load **demo/sample data**  
- Create an admin user: `admin / admin`  
- Install OroCommerce in **development mode**

### 2.6 Run the application (development server)

For a simple dev setup you can use PHP’s built-in web server:

    php -S 0.0.0.0:8000 -t public

Then open your browser and go to:

- Application: http://localhost:8000

- Backoffice: http://localhost/admin  
- Login: `admin / admin`

---

## 3. Viewing the PDP Stock Customization

1. Log in as `admin`.
2. Ensure a website and products are available (sample data already provides them).
3. Switch to the **Storefront**.
4. Open any **Product Detail Page (PDP)**.

You will see a **customized stock label** instead of the default one. The behavior is:

- Quantity > 0  
  - If the system configuration `highlight_low_inventory` is enabled **and** the quantity is less than or equal to `low_inventory_threshold`:  
    - Show **“Low stock”** with a warning style.  
  - Otherwise:  
    - Show **“In stock”** with a success style.

- Quantity == 0  
  - If the product inventory status is still **“In Stock”** (orderable / backorder / made-to-order case):  
    - Show **“In stock – contact seller”** with an informational style.  
  - If the status is not “In Stock”:  
    - Show **“Out of stock”** with an error style.

The configuration values are taken from:

- System → Configuration → Inventory → Product Options → **Highlight Low Inventory**  
- System → Configuration → Inventory → Product Options → **Low Inventory Threshold**


---

## 4. License

This project is based on **OroCommerce Community Edition** and remains under the original **OSL-3.0** license from Oro Inc.
