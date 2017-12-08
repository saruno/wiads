Quy định kích thước QC màn hình multi-slot:
//Quy dinh
//QA0:1242x698
//QA1: 842x740
//QA2: 401x590
//QA0_v4: 300x600
//QA1_v4,QA2_v4: 336x280
//QA3_v4: 300x250
//QA4_v4: 335x114
//QAF_v4: 640x717 full screen ads

===========
Chay script sau khi tao ads moi
TRUNCATE TABLE ads_distribution
insert into `ads_distribution` (advert_id) select id from advert where advert.view_at_homepage=1

===========
            
Tạo tài khoản của một khách hàng đăng quảng cáo:
1. Thêm 1 acc ở bảng user
2. Gán quyền ở bảng Role_Assign với role = 6
3. Thêm 1 hàng ở bảng Customer, với name = username ở bước 1
4. Thêm 1 hàng ở advert, customer_id là id ở bước 3.
5. Thêm 1 hàng ở advert_i18n, id là id của bước 4.

Nếu khách hàng đã có thì thực hiện đăng QC chỉ dùng bước 4 và 5.
==================== Migration ================
STEP:
1. Edit the XML schema to modify the model
2. Call the diff task to create a migration class containing the SQL statements altering the database structure
```
php app/console propel:migration:diff --connection default
```
3. Review the migration class Propel just generated, and add data migration code if necessary
```
php app/console propel:migration:migrate --connection default
```
4. Execute the migration using the migrate task.
5. Build model from schema
```
php app/console propel:model:build
```
//https://github.com/artf/grapesjs