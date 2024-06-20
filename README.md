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

## Struktura projektu

- **assets**
  - **img**: Obrázky pro webové stránky
  - **video**: Vide soubory pro webové stránky
  - **ikona.ico**: Favicon
- **css**: Styly pro webové stránky
- **include**
  - **dbConnection.php**: Připojení k databázi
  - **navigation.php**: Navigační menu
  - **UserManager.php**: Správa uživatelů
- **js**: JavaScript soubory pro webové stránky
- **uploads**: Nahrané obrázky a soubory
- **about.php**: Stránka O nás
- **admin.php**: Administrátorský panel
- **create_post.php**: Vytvoření nového článku
- **edit_post.php**: Úprava existujícího článku
- **index.php**: Hlavní stránka s výpisem článků
- **login.php**: Přihlášení uživatele
- **logout.php**: Odhlášení uživatele
- **post.php**: Detailní zobrazení článku s možností komentářů
- **profile.php**: Správa uživatelského profilu a článků
- **register.php**: Registrace nového uživatele

## Databázová struktura

- **users**: Tabulka pro uživatelské účty (id, username, email, password, role).
- **articles**: Tabulka pro články (id, title, content, image, author_id, created_at).
- **comments**: Tabulka pro komentáře (id, content, article_id, author_id, created_at).

## Technologický stack

- **Frontend**: HTML, CSS, Bootstrap, JavaScript
- **Backend**: PHP
- **Databáze**: MySQL

## Instalace a spuštění

1. Naklonujte si repozitář:
    ```bash
    git clone https://github.com/yourusername/musicca.git
    ```

2. Importujte databázovou strukturu (soubor `database.sql`) do MySQL.

3. Nastavte připojení k databázi v souboru `include/dbConnection.php`.

4. Spusťte aplikaci na lokálním serveru (např. XAMPP nebo WAMP).

5. Otevřete prohlížeč a přejděte na `http://localhost/blogwa`.

## Příspěvky a podpora

Rádi uvítáme vaše příspěvky a zpětnou vazbu. Pokud naleznete chyby nebo máte nápady na vylepšení, neváhejte otevřít issue nebo vytvořit pull request.

## Licence

Tento projekt je licencován pod licencí MIT.
