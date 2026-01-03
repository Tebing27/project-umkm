Database Integration and Best Practices Plan
Goal Description
The goal is to make the UMKM application fully dynamic by connecting all views to the database. This includes managing shop photos, products, and ensuring that public pages (umkm.index, umkm.detail) display real, verified data. The implementation will follow best practices for code quality, SQL performance (eager loading), security (validation), and SEO.

User Review Required
IMPORTANT

Photo Storage: Photos will be stored in the local filesystem (public disk) as requested (storage/app/public/shops/...). Ensure php artisan storage:link is run.

NOTE

Product Schema: I will add a products table with fields: name, price, category, image path, and variant.

NOTE

Shop Photos: I will add a shop_photos table to handle the gallery slider (up to 5 photos) separately from the main 
Shop
 table.

Proposed Changes
Database & Models
[NEW] Region Model & Migration
Table: regions
Columns: id, name, image (for home slider), timestamps.
Seeder: Populate with existing data (Cinangka, Kedaung, Sawangan, Pengasinan, Bojongsari, Pasir Putih, Bedahan).
[NEW] ShopPhoto Model & Migration
Table: shop_photos
Columns: id, shop_id (FK), path, order, timestamps.
Relation: 
Shop
 hasMany ShopPhoto.
[NEW] Product Model & Migration
Table: products
Columns: id, shop_id (FK), name, price, category, image, variant (nullable), description (nullable), timestamps.
Relation: 
Shop
 hasMany Product.
[MODIFY] 
Shop
 Model & Migration
Add region_id (FK to regions) to shops table.
Add relationship region() belongsTo Region.
Controllers
[NEW] HomeController.php
index()
:
Fetch regions with shops_count (e.g. Region::withCount('shops')->get()).
Fetch hero_shops (random 3 verified shops with high omset/rating or just random).
Fetch map_shops (all verified shops with lat/long).
[MODIFY] 
UserDashboardController.php
Update 
updateToko
: Handle region_id.
Add method storePhoto(Request $request): Handle file upload, save to storage, save to DB.
Add method deletePhoto($id): Remove file and DB record.
Add method storeProduct(Request $request): Validate and save product.
Add method updateProduct(Request $request, $id).
Add method deleteProduct($id).
[MODIFY] 
ProfileController.php
 / New SettingController
Handle updates to User profile and Password from users/setting and admin/setting.
[NEW] PublicController.php (or merge into Home/ShopController)
index()
: Fetch all is_verified shops with pagination. Support search/filtering.
show($id): Fetch shop with products and photos.
Views
[MODIFY] 
home.blade.php
Pass dynamic $regions and $heroShops to components.
[MODIFY] 
components/home/hero.blade.php
Replace static AlpineJS items with data from backend (json_encode).
[MODIFY] 
components/home/wilayah.blade.php
Replace static AlpineJS items with $regions data.
[MODIFY] 
components/home/lokasi.blade.php
Inject all verified shops as JSON for the map.
[MODIFY] 
auth/register.blade.php
Populate "Wilayah" dropdown from DB ($regions).
Ensure region_id is submitted.
[MODIFY] 
kelola-foto.blade.php
Replace static AlpineJS logic with form submissions or Fetch API to 
UserDashboardController
.
Display existing photos from DB.
[MODIFY] 
toko.blade.php
Loop through $shop->products.
Connect "Add Product" and "Edit Product" modals to backend routes.
[MODIFY] 
umkm/index.blade.php
Replace static cards with @foreach($shops as $shop).
Implement real search/filter logic.
[MODIFY] 
umkm/detail.blade.php
Display dynamic shop info (Name, Address, Socials).
Display dynamic photos in slider.
Display dynamic products in grid.
Optimization & SEO
SEO: Add semantic <meta> tags (title, description) in layouts/app.blade.php.
SQL: Use Shop::with(['photos', 'products']) in controllers to avoid N+1 queries.
Validation: Strict validation for file types (images only) and sizes.
Verification Plan
Automated Tests
None existing. I will rely on manual verification as per current workflow.
Manual Verification
Register as User: Create a new account and shop.
Manage Shop:
Upload 5 photos (Cover + 4 slider). Verify they appear in storage folder and DB.
Add 3 products (Food & Drink). Verify DB.
Admin Login:
Log in as Admin.
Verify the new shop.
Public Access:
Visit /umkm. Verify the shop appears.
Visit Shop Detail. Verify photos slider works and products are listed.
SEO Check: Inspect Page Source to verify Title and Meta Description.

Untuk menjalankan php pakai kamu bisa cek docker-compose.yml atau docker exec -it laravel_php bash