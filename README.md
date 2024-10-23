
### Orden de ejecución del proyecto

1. **`composer install`**: 
2. **`php artisan migrate`**: 
3. **`npm install`**: 
4. **`npm run dev` / `npm run build`**: 
5. **`php artisan serve`**: 
6. **`php artisan db:seed --class=UserSeeder`**
7. **`php artisan db:seed --class=UserSeeder`**
8. **`php artisan db:seed --class=ProjectSeeder`**
9. **`php artisan db:seed --class=TaskSeeder`**

En caso de ejecutar los seeders, los usuarios que se crean: 
**`correo: uan@example.com  contraseña: password123`**

**`correo: maria@example.com contraseña: password123`**

He mantenido el .env para facilitar el uso de la aplicación
