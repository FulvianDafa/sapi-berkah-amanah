export function generateWaLink(namaSapi, berat, harga, nomorWa) {
    return `https://wa.me/${nomorWa}?text=Halo%20saya%20tertarik%20dengan%20sapi%20${namaSapi}%20berat%20${berat}%20kg%20seharga%20Rp${harga.toLocaleString()}.`
  }
  