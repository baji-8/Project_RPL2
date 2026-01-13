echo "# Project_RPL2" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/baji-8/Project_RPL2.git
git push -u origin main

step run website Laravel (first time)
1. run xampp apache dan MySQL
2. buka terminal di file projek pppl2
3. npm install
4. composer install
5. copy .env.example .env
6. php artisan key:generate
7. npm run dev (buat css)
8. php artisan serve (preview localhost website)
9. buat database di phpmyadmin
10. php artisan migrate:fresh --seed (migrate database php)
11. php artisan storage:link
