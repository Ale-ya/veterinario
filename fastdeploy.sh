#!/bin/bash
#script per eseguire il deploy su distribuzioni basate su debian, che sfruttano apache2

set -e  #per interrompere lo script in caso di errore

SOURCE="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)" #per trovare sempre il percorso dove è lo script (per farlo funzionare anche se lo si esegue da una cartella diversa da quella in cui è)
DESTINATION="/var/www/html/veterinario/"

echo "📂 --> creazione cartella di destinazione (se serve)..."
#per assicurarsi di creare la cartella di destinazione. togliere -p se non si vuole creare tutto il tree delle cartelle, 
#utile se si usa un sistema diverso da quelli basati su debian
sudo mkdir -p "$DESTINATION" 

echo "copia in corso..."

#sync delle modifiche con esclusione dei file inutili 
sudo rsync -av --delete --delete-excluded "$SOURCE/" "$DESTINATION" \
  --exclude '.git' \
  --exclude 'fast_deploy.sh' \
  --exclude 'fast_container_deploy.sh' \
  --exclude 'database' \
  --exclude 'README.md'
#cambio proprietà dei file e della cartella in modo ricorsivo (-R)
sudo chown -R www-data:www-data "$DESTINATION"


echo "deploy completato"


