# Synchronisation de l'équipe — GbeCosmoLingua

## Pourquoi Git ne suffit pas

| Dans Git (partagé) | Hors Git (local à chaque PC) |
|--------------------|------------------------------|
| Thème `gbecosmolingua` | **Pages WordPress** |
| Plugin `gbecosmolingua-core` | Textes, réglages composeur admin |
| `docker-compose.yml` | **Base MySQL** (volume Docker `db_data`) |
| Scripts | **Médias uploadés** (volume Docker `uploads_data`) |

Quand vous ajoutez des **images** ou modifiez des **textes** dans l’admin WordPress, cela reste sur **votre PC**. Un simple `git pull` ne suffit pas.

---

## Workflow — responsable (après modifications contenu)

**Linux / macOS / Git Bash (Windows) :**

```bash
cd gbecosmolingua
git add .
git commit -m "Mise à jour code"
git push

bash scripts/export-content.sh
```

Envoyer à l’équipe (Drive, Slack, WeTransfer…) **deux fichiers** :

| Fichier | Contenu |
|---------|---------|
| `backups/gbe_wp-latest.sql` | Pages, textes, liens vers les images |
| `backups/gbe_uploads-latest.tar.gz` | Fichiers images réels |

Ne pas mettre ces fichiers sur GitHub (trop lourds).

---

## Windows — prérequis collègues

1. [Git for Windows](https://git-scm.com/download/win) (inclut **Git Bash**)
2. [Docker Desktop](https://www.docker.com/products/docker-desktop/) — activer **WSL 2** si demandé
3. Cloner le dépôt :

```bash
git clone git@github.com:DavidAtikpo/gbecosmolingua.git
cd gbecosmolingua
```

> Utiliser **Git Bash** pour les commandes `bash scripts/...` ci-dessous (pas obligatoire en PowerShell).

---

## Windows — première installation

1. Ouvrir **Git Bash** dans le dossier du projet.

2. Démarrer Docker :

```bash
docker compose up -d
```

3. (Optionnel) Squelette initial des pages :

```bash
bash scripts/start-and-seed.sh
```

4. Placer les fichiers reçus dans `backups/` :
   - `gbe_wp-latest.sql`
   - `gbe_uploads-latest.tar.gz`

5. Importer **base + médias** :

```bash
bash scripts/import-db.sh
bash scripts/import-uploads.sh
```

6. Ouvrir : **http://localhost:8080**

7. Admin : **http://localhost:8080/wp-admin**  
   Si besoin : **GbeCosmoLingua → Réinitialiser en-tête et pied de page**

---

## Windows — mise à jour (collègue)

1. Recevoir les 2 fichiers du responsable → les mettre dans `backups/`

2. Git Bash :

```bash
cd gbecosmolingua
git pull
docker compose up -d
bash scripts/import-db.sh
bash scripts/import-uploads.sh
```

3. Rechargement forcé du navigateur : **Ctrl + F5**

---

## Windows — PowerShell (Docker uniquement)

PowerShell suffit pour Git et Docker :

```powershell
cd gbecosmolingua
git pull
docker compose up -d
```

Puis ouvrir **Git Bash** pour l’import :

```bash
bash scripts/import-db.sh
bash scripts/import-uploads.sh
```

---

## Linux / macOS — rappel

```bash
git pull
docker compose up -d
bash scripts/import-db.sh
bash scripts/import-uploads.sh
```

Export complet :

```bash
bash scripts/export-content.sh
```

---

## Dépannage Windows

### « bash: command not found »

Ouvrir **Git Bash** (menu Démarrer → Git Bash), pas l’invite CMD seule.

### « permission denied » sur Docker

Docker Desktop doit être **lancé** (icône dans la barre des tâches). Redémarrer Docker Desktop si besoin.

### « permission denied » sur `backups/`

Dans Git Bash :

```bash
rm -f backups/gbe_wp-latest.sql
bash scripts/export-db.sh
```

### Les images ne s’affichent pas

Importer **les deux** fichiers : SQL **et** `gbe_uploads-latest.tar.gz`.

### Port 8080 déjà utilisé

Modifier `docker-compose.yml` : `"8080:80"` → `"8088:80"`, puis `http://localhost:8088`

---

## Résumé

| Quoi | Comment |
|------|---------|
| **Code** (CSS, JS, PHP) | `git push` / `git pull` |
| **Contenu** (pages, textes, images) | `export-content.sh` → envoyer SQL + tar.gz → `import-db.sh` + `import-uploads.sh` |
| **En-tête / menu** | Admin → Réinitialiser en-tête et pied de page |
