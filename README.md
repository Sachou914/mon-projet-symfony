# 🛍️ E-Boutique Symfony

Ce projet est une boutique en ligne développée avec le framework **Symfony**. Il propose une expérience utilisateur fluide permettant de naviguer, s'inscrire, commander, et gérer les produits depuis un back-office.

> 🔗 **Site en production :** [https://sacha914.alwaysdata.net/](https://sacha914.alwaysdata.net/)  
> 💻 **Code source :** [https://github.com/Sachou914/mon-projet-symfony](https://github.com/Sachou914/mon-projet-symfony)

---

## ✅ Fonctionnalités & Statut

| Fonctionnalité                                        | Statut                                     |
|-------------------------------------------------------|--------------------------------------------|
| 🔐 **Login (Connexion)**                              | ✅ OK                                       |
| 📝 **Inscription**                                    | ✅ OK                                       |
| 🗂️ **Parcours par catégorie**                         | ✅ OK                                       |
| 🛒 **Parcours des articles**                          | ✅ OK                                       |
| 🧺 **Ajout au panier**                                | ✅ OK                                       |
| ➕ **Ajustement des quantités avec total dynamique**  | ✅ OK                                       |
| 📩 **Message de confirmation de commande**            | ✅ OK                                       |
| 🆕 **Ajout d’un nouveau type d’article**              | ✅ OK                                       |
| 🆕 **Ajout d’une nouvelle catégorie**                 | ✅ OK                                       |
| 👥 **Gestion avancée des utilisateurs**               | ✅ OK                                       |

---

## 🎁 Bonus Fonctionnalités Implémentées

| Bonus                                        | Description                                                                  | Statut |
|----------------------------------------------|------------------------------------------------------------------------------|--------|
| 🎨 Interface responsive                      | Site bien adapté aux mobiles et tablettes                                    | ✅ OK  |
| 🛍️ Présentation claire des produits          | Produits bien illustrés et organisés                                         | ✅ OK  |
| 🔐 Mot de passe haché                        | Hachage des mots de passe stockés dans la base de données (sécurité)         | ✅ OK  |
| 📄 Sécurité des formulaires                  | Protection contre soumissions malveillantes                                  | ✅ OK  |
| 🧑‍💼 Interface admin (CRUD produits, catégories) | Back-office avec gestion simple des contenus                               | ✅ OK  |



## 🛠️ Technologies utilisées

- PHP 8.x
- Symfony 6.x
- Twig
- Bootstrap 5
- JavaScript (AJAX pour le panier)
- MySQL / SQLite
- Hébergement : Alwaysdata

---

## ⚙️ Installation en local

```bash
git clone https://github.com/MonCompte/e-boutique-symfony.git
cd e-boutique-symfony
composer install
cp .env .env.local
# Configure ta base de données dans .env.local
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
symfony server:start
