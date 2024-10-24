----CONFIGURACION PARA CODIGO QR----

    Para que funcione lo de qr, hay que realizar cambios en el archivo "php.ini" dentro de xampp.
    Dentro del mismo buscar "extensions=gd" y eliminar el ";"


Pregunlam G3 pasos:

1) Descomprimir en htdocs
2) Cambiar la el DocumentRoot y Directory de Apache en httpd.conf a:
					DocumentRoot "C:\xampp\htdocs\Pregunlam"
					<Directory "C:\xampp\htdocs\Pregunlam">
3) Reiniciar Apache



---HABILITAR EXTENSION ZIP---
Para instalar el phpunit con composer, deberan ir al archivo php.ini dentro de
xampp , y en el mismo deberan elimnar el primer ";" de "extensions=zip"

