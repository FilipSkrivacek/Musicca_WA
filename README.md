# Musicca

Musicca je webová aplikace určená pro blogování o hudebních novinkách a dění ve světě DJů. Tento projekt byl vytvořen jako semestrální práce v rámci kurzu webového vývoje. 

## Hlavní funkce

1. **Uživatelská autentizace**
   - Registrovat nový uživatelský účet
   - Přihlásit se do systému
   - Odhlásit se ze systému

2. **Správa uživatelských účtů**
   - Každý uživatel má svůj profil, kde může spravovat své údaje
   - Administrátor má práva pro správu všech uživatelských účtů

3. **Publikace článků**
   - Registrovaní uživatelé mohou vytvářet nové články
   - Články jsou zobrazovány na hlavní stránce
   - Možnost přidávat obrázky k článkům

4. **Úprava a mazání článků**
   - Uživatelé mohou upravovat a mazat své vlastní články
   - Administrátor má práva upravovat a mazat jakýkoliv článek

5. **Správa komentářů**
   - Registrovaní uživatelé mohou přidávat komentáře k článkům
   - Uživatelé mohou mazat své vlastní komentáře
   - Administrátor má práva mazat jakékoliv komentáře

## Databázová struktura

- **users**: Tabulka pro uživatelské účty (id, username, email, password, role).
- **articles**: Tabulka pro články (id, title, content, image, author_id, created_at).
- **comments**: Tabulka pro komentáře (id, content, article_id, author_id, created_at).


## Instalace a spuštění

1. Naklonujte si repozitář:
    ```bash
    git clone https://github.com/yourusername/musicca.git
    ```

2. Importujte databázovou strukturu (soubor `dj_blog.sql` ve složce database) do MySQL.

3. Nastavte připojení k databázi v souboru `include/dbConnection.php`.

4. Spusťte aplikaci na lokálním serveru (např. XAMPP nebo WAMP).

5. Otevřete prohlížeč a přejděte na `http://localhost/blogwa`.


