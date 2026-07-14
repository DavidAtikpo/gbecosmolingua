# Synchronisation de l'équipe — GbeCosmoLingua

## Pourquoi Git ne suffit pas

| Dans Git (partagé) | Hors Git (local à chaque PC) |
|--------------------|------------------------------|
| Thème `gbecosmolingua` | **Pages WordPress** |
| Plugin `gbecosmolingua-core` | Articles, proverbes, partenaires |
| `docker-compose.yml` | **Base MySQL** (`db_data`) |
| Scripts | Médias uploadés (`uploads_data`) |

Quand vous créez ou modifiez des **pages dans l'admin WordPress**, cela reste dans **votre base Docker locale**. Vos collègues ne les voient pas avec un simple `git pull`.

---

## Workflow recommandé

### Responsable (après avoir créé/modifié des pages)

```bash
cd gbecosmolingua
git add .
git commit -m "Mise à jour code"
git push

# Exporter la base
bash scripts/export-db.sh
```

Envoyer **`backups/gbe_wp-latest.sql`** à l'équipe (Google Drive, Slack, WeTransfer…).

### Chaque développeur (Linux, macOS, Git Bash Windows)

```bash
cd gbecosmolingua
git pull
docker compose up -d

# Importer la base du responsable
bash scripts/import-db.sh backups/gbe_wp-latest.sql

# Code + en-tête à jour
bash scripts/start-and-seed.sh   # optionnel si import complet
```

Puis dans l'admin : **GbeCosmoLingua → Réinitialiser en-tête et pied de page**

---

## Première installation (nouveau collègue)

```bash
git clone git@github.com:DavidAtikpo/gbecosmolingua.git
cd gbecosmolingua
docker compose up -d
bash scripts/start-and-seed.sh          # structure ~120 pages
bash scripts/import-db.sh chemin/gbe_wp-latest.sql   # vos vraies pages
```

Sans le fichier SQL : seulement le **squelette** des pages (contenu minimal).

---

## Windows (PowerShell + Docker Desktop)

```powershell
cd gbecosmolingua
git pull
docker compose up -d
```

Puis **Git Bash** :

```bash
bash scripts/import-db.sh backups/gbe_wp-latest.sql
```

---

## Docker : permission denied

```bash
sudo usermod -aG docker $USER
# Déconnexion / reconnexion
newgrp docker
```

Ou temporairement : `sudo docker compose up -d`

---

## Uploads (images)

Les images restent dans le volume Docker `uploads_data`. Pour les partager :

- ré-uploader via **Médias** après import SQL, ou
- exporter le volume (avancé)

Le **logo du thème** est dans Git : `themes/gbecosmolingua/assets/images/`

---

## Résumé

1. **Code** → GitHub (`git push` / `git pull`)
2. **Pages et contenus** → fichier `gbe_wp-latest.sql` (`export-db.sh` / `import-db.sh`)
3. **En-tête/menu** → bouton admin « Réinitialiser en-tête et pied de page »
