
### Orden de ejecución del proyecto

1. **`composer install`**: 
2. **`npm install`** : 
3. **`php artisan migrate`**: 
4. **`npm run dev` / `npm run build`**:
5. **`php artisan db:seed --class=UserSeeder`**
6. **`php artisan db:seed --class=UserSeeder`**
7. **`php artisan db:seed --class=ProjectSeeder`**
8. **`php artisan db:seed --class=TaskSeeder`**
9.  **`php artisan serve`**: 

En caso de ejecutar los seeders, los usuarios que se crean: 
**`correo: uan@example.com  contraseña: password123`**

**`correo: maria@example.com contraseña: password123`**

He mantenido el .env para facilitar el uso de la aplicación
