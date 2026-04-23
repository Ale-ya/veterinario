#!/bin/bash
# Script unificato per il deploy remoto su server Debian/Apache via SSH

set -e  # Interrompe lo script in caso di errore

# --- CONFIGURAZIONE ---
SSH_USER="root"
SSH_IP="192.168.200.253"
REMOTE_DESTINATION="/var/www/html/veterinario/"
LOCAL_SOURCE="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SYSTEMUSER="www-data"
echo "Inizio deploy remoto su $SSH_IP usando l'utente $SSH_USER"

#creazione della cartella remota (se non esiste)
echo "Creazione cartella di destinazione remota..."
ssh $SSH_USER@$SSH_IP "mkdir -p $REMOTE_DESTINATION"

#l'opzione -e ssh forza l'uso del tunnel SSH
echo "📦 Sincronizzazione file in corso..."
rsync -avz --delete --delete-excluded -e ssh "$LOCAL_SOURCE/" "$SSH_USER@$SSH_IP:$REMOTE_DESTINATION" \
  --exclude '.git' \
  --exclude 'deploy.sh' \
  --exclude 'README.md'

#cambio proprietà dei file sul server remoto
echo "configurazione permessi usando l'utente $SYSTEMUSER..."
ssh $SSH_USER@$SSH_IP "chown -R $SYSTEMUSER:$SYSTEMUSER $REMOTE_DESTINATION"

echo "Deploy completato con successo su $SSH_IP!"
