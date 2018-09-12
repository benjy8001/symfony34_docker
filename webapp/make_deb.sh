#!/bin/bash

TMPDIRDEB="tmp_deb/symfony"
DST="${TMPDIRDEB}/mnt/apps/symfony"
VHOST="${TMPDIRDEB}/etc/apache2/sites-available"

if [[ -d "${TMPDIRDEB}" ]]; then
    rm -rf "${TMPDIRDEB}"
fi

mkdir -p "${DST}"
mkdir -p "${VHOST}"

rsync -av "." "${DST}" --exclude-from='deb.exclude'
cp -r "debian" "${TMPDIRDEB}"
cp "etc/symfony.conf" "${VHOST}/"

cd ${TMPDIRDEB}/debian

#new repo
debuild
debuild clean

#old repo
#dpkg-deb -b ${TMPDIRDEB} ../

cd ../../../
rm -rf "${TMPDIRDEB}"
