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


---ENTORNO DE PRUEBAS---

define('TEST_ENV', true);

Esto lo que hace en los test es definir los entornos de pruebas para asi evitar el llamado
de views utilizado el presenter. El mismo se define dentro del mismo metodo de la
clase a la que estamos llamando
y en el test mismo. (Ejemplo en respuestaController)



