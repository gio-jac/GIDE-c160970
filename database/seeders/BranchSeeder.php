<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create(['address' => 'Calle: Av. Circumvalacion agustin yañes 440 col, Rincon de Agua Azul cp. 44467', 'city_id' => 28, 'client_id' => 1]);
        Branch::create(['address' => 'BLVD Timoteo Lozano 628A, San Miguel, Leon de los aldama Gto cp.37390', 'city_id' => 37, 'client_id' => 1]);

        Branch::create(['address' => 'Calle: Andres de Urdaneta #35 Colonia: Fraccionamiento hornos C.P 39355', 'city_id' => 1, 'client_id' => 4]);
        Branch::create(['address' => 'AV.LOPEZ MATEOS ENTRE ABASOLO Y JUSTO SIERRA  #266 Colonia: San Roma C.P 24040', 'city_id' => 3, 'client_id' => 4]);
        Branch::create(['address' => 'Av. Chichen Itza No.98  Col.32 C.P 77537', 'city_id' => 4, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: AQUILES CALDERON MARCHENA Col. Centro CP 86500', 'city_id' => 5, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: SOR JUANA INES DE LA CRUZ 111 SUR Col: Ricardo Flores Magón CP89460', 'city_id' => 39, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: MONTERREY # 1402 NORTE CoL. Canoas C.P 89829', 'city_id' => 8, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: PINO SUAREZ #414 Col.BELLAVISTA P.C79084', 'city_id' => 9, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: 20 A #70 Col. GUANAL C.P 24130', 'city_id' => 6, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: MIER Y TERAN #104 Col. Zona Centro  C.P 87000', 'city_id' => 10, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: Benito Juarez Col. Centro C.P 77000', 'city_id' => 15, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: SOFIA TENA  Col. MARGARITA VIGURI C.P39060', 'city_id' => 17, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: Martíes del 7 de Enero Esq. Álamos s/n Col. 1ro de Mayo C.P 96590', 'city_id' => 18, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: AV 41 S/N Col. Paraíso C.P 94650', 'city_id' => 20, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: 65 AV. POR 7 SUR Col. CUZAMIL C.P 77600', 'city_id' => 21, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: FRANCISCO I MADERO #157 Col. EMILIANO ZAPATA C.P 62744', 'city_id' => 22, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: Av. Emiliano Zapata 600 - A Col. Bella Vista C.P 62140', 'city_id' => 23, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: AV. MARINO ABASOLO #903 Col. Centro C.P 86997', 'city_id' => 26, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: BLVD. ADOLFO LOPEZ MATEOS #23  Col. AVIACION CIVIL C.P 43000', 'city_id' => 30, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: J.OCAMPO Col. Centro C.P 40000', 'city_id' => 31, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: RUBEN BUCHEZ #12 Col. TAMBORREL C.P 91050', 'city_id' => 33, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: CALLEJÓN DE CUITLAHUAC #160 Col. LORENZO BOTURINI C.P 15820', 'city_id' => 35, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: Miguel Hidalgo Col. Centro C.P 60950', 'city_id' => 36, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: Neptuno num 110 entre canales y astros Col. Alianza C.P 87410', 'city_id' => 40, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: C.70 #523 X 65 Y 67  Col. Centro C.P 97000', 'city_id' => 42, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: Popocatepetl No.215 entre nevado de Colima Paricutin Col. Urdiales C.P 64430', 'city_id' => 45, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: GONZALEZ ORTEGA #208 Col. Centro C.P 68000', 'city_id' => 48, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: SUR 17 # 141 ENTRE OTE 2 Y 4  Col. Centro C.P 94300', 'city_id' => 49, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: CARLOS CASTELAN CANALES  NUM.305 Col. MAESTRANZA C.P 42060', 'city_id' => 50, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: 2DA. NORTE #402 Col. BARRIO DE LAS FLORES C.P 71600 ', 'city_id' => 52, 'client_id' => 4]);
        Branch::create(['address' => 'Calle:  30  A NTE BIS Col. EJIDAL C.P 77723 ', 'city_id' => 53, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: Ave Ferrocarril  #137 Col.  Aviacion Vieja C.P 93370', 'city_id' => 54, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: Av.Reforma No. 1510 Col. San Matías C.P 72000', 'city_id' => 56, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: CARRETERA LA COSTERA S/N Col. GRANJAS EL PESCADOR  C.P   71980 ', 'city_id' => 57, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: Veracruz No.401 Esq. Fco. I Madero Col. Hidalgo Poniente C.P 70610 ', 'city_id' => 60, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: 12 poninte entre central y segunda Col. Centro CP. 307000', 'city_id' => 64, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: PRIVADA DE LA 9 NORTE NO 710 Col. Centro C.P 75700', 'city_id' => 65, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: AV. LUIS AUDIRACNO. 29 Col.  BO. DE FRANCIA C.P 73880 ', 'city_id' => 67, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: AV ZARAGOZA N. 13 Col.  1RA SECCION, SANTA MARIA ACUITLAPILCO C.P 90110', 'city_id' => 70, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: BOULEVARD TULA - TLAHUELILPAN Col. EL TESORO C.P42800', 'city_id' => 73, 'client_id' => 4]);
        Branch::create(['address' => 'Calle Melchor Ocampo No. 89 Col. Enrique Rodríguez Cano C.P. 92880', 'city_id' => 74, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: IGNACIO MATIAS N0. 58 Y 66 Col. El Reposo C.P 68320', 'city_id' => 75, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: 4a NORTE ORIENTE No. 1856  Col. FRACC. SANTOS  C.P 29040', 'city_id' => 76, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: Simon Bolivar 1310 Col. Fracc. Moderno C.P 91910 ', 'city_id' => 78, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: Aquilés Serdán # 426 Col. 2da. Del Aguila C.P 86180', 'city_id' => 79, 'client_id' => 4]);
        Branch::create(['address' => 'Calle: ANDADOR 6 LOTE4 MZA 19 Col. EL HUJAL, ZIHUATANEJO,GRO C.P 40880', 'city_id' => 84, 'client_id' => 4]);

        Branch::create(['address' => 'Prolongación Sabino No. 526, Col. Ampliación del Gas, C.P.02830, Alc. Azcapotzalco, México, CDMX.', 'city_id' => 11, 'client_id' => 5]);
        Branch::create(['address' => 'Galeana No. 308 Ote. Col. Treviño N.L MX,Esquina  Calz. Guadalupe Victoria, 64570 Monterrey, N.L.', 'city_id' => 45, 'client_id' => 5]);
        Branch::create(['address' => 'Av. Primero de Mayo 1705, Delegación Sta Ana Tlapaltitlán, 50160 Toluca de Lerdo, Méx.', 'city_id' => 71, 'client_id' => 5]);
        Branch::create(['address' => 'Av. Adolfo Ruiz Cortines No. 2023-A Col, Atasta de Serra, 86100 Villahermosa, Tab.', 'city_id' => 79, 'client_id' => 5]);

        Branch::create(['address' => 'REGION 97 AV. COMALCALCO MZ6 L1 COL. ZONA INDUSTRIAL CP. 77530', 'city_id' => 4, 'client_id' => 6]);
        Branch::create(['address' => 'Rio Nilo 445 Entre Gladiola Y Perez Verdia  col. San Carlos 44860 Guadalajara, Jal', 'city_id' => 28, 'client_id' => 6]);
        Branch::create(['address' => 'HELIODORO VALLE #229 COL MERCED BALBUENA CP.15810 DEL . VENUSTIANO CARRANZA', 'city_id' => 29, 'client_id' => 6]);
        Branch::create(['address' => 'Calle 35 Num 311 X 20 Y 20 A Pedregales De Tanlum 97210 Mérida, Yuc', 'city_id' => 42, 'client_id' => 6]);
        Branch::create(['address' => 'IGNACIO LOPEZ RAYON #404 COL LAS HUERTAS GUADALUPE NUVO LEON CP. 67140', 'city_id' => 45, 'client_id' => 6]);
        Branch::create(['address' => 'Calle 10 Pte. 1303 Entre la 13 norte y la 15 norte, frente al Museo del Ferrocarril Centro 72000 Puebla , Puebla', 'city_id' => 56, 'client_id' => 6]);
        Branch::create(['address' => 'Abraham Lincoln Núm. 8 Zona Industrial Carrillo Puerto 76138 Querétaro, Qro.', 'city_id' => 58, 'client_id' => 6]);
        Branch::create(['address' => 'Graciano Sánchez No. 120 Del Valle 78200 San Luis Potosí, S.L.P.', 'city_id' => 62, 'client_id' => 6]);
        Branch::create(['address' => 'Rep. Del Salvador No. 210 y Av. Mexico Américas 50160 Toluca, Edo De México', 'city_id' => 71, 'client_id' => 6]);
        Branch::create(['address' => 'Maria Auxiliadora No 525 Fracc Los Pinos  Fracc Los Pinos  91870 Veracruz, Ver', 'city_id' => 78, 'client_id' => 6]);
        Branch::create(['address' => 'Ursulo Galvan 219 col. Centro C.P 91000  JALAPA ENRIQUEZ', 'city_id' => 80, 'client_id' => 6]);
        
        Branch::create(['address' => 'NIETO No. 717-A, ZONA CENTRO, COL. SAN MARCOS, C.P.20070, AGUASCALIENTES, AGS.', 'city_id' => 2, 'client_id' => 7]);
        Branch::create(['address' => 'CALLE HENRY DUNANT N°4827,  COLONIA PROGRESISTA, C.P.32310, CD.JUAREZ, CHIHUAHUA', 'city_id' => 7, 'client_id' => 7]);
        Branch::create(['address' => 'BLVD. ADOLFO LOPEZ MATEOS #1518, COL. RENACIMIENTO, C.P. 38048, CELAYA, GUANAJUATO.', 'city_id' => 14, 'client_id' => 7]);
        Branch::create(['address' => 'CALLE 26 No. 1825, COL. SANTA RITA, C.P. 31020, CHIHUAHUA, CHIHUAHUA.', 'city_id' => 16, 'client_id' => 7]);
        Branch::create(['address' => 'MANUEL ALVAREZ No. 502, COL. FATIMA, C.P. 28050, COLIMA, COLIMA.', 'city_id' => 19, 'client_id' => 7]);
        Branch::create(['address' => 'DR. BARRAGAN No. 154 COL. DOCTORES, C.P. 06720, DEL. CUAUHTEMOC, CDMX.', 'city_id' => 11, 'client_id' => 7]);
        Branch::create(['address' => 'GENERAL JOSE MARIA PATONI # 7121 INTERIOR 5 y 6, COLONIA 5 DE MAYO,  CP 34000, DURANGO, DURANGO.', 'city_id' => 25, 'client_id' => 7]);
        Branch::create(['address' => 'AV. ESPINOZA 843 Y CALLE OCTAVA, COL. OBRERA, C.P. 22830, ENSENADA, B.C.', 'city_id' => 27, 'client_id' => 7]);
        Branch::create(['address' => 'GLADIOLA No. 1039 SECTOR ROMA, COL. SAN CARLOS, GUADALAJARA, JALISCO,  C.P. 44460', 'city_id' => 28, 'client_id' => 7]);
        Branch::create(['address' => 'MORELOS 223, COL. BARRIO DE SAN MIGUEL, ZONA CENTRO, C.P. 36500, IRAPUATO, GUANAJUATO.', 'city_id' => 32, 'client_id' => 7]);
        Branch::create(['address' => 'BLVD. AGUSTIN OLACHEA, PROLONGACIÓN PITAHAYA No. 1270, COL. LAS GARZAS, C.P. 23070, LA PAZ, B.C.S.', 'city_id' => 34, 'client_id' => 7]);
        Branch::create(['address' => 'CARDADORES No. 202-A, COL. FRACC. INDUSTRIAL JULIAN DE OBREGON, C.P. 37280, LEON, GUANAJUATO.', 'city_id' => 37, 'client_id' => 7]);
        Branch::create(['address' => 'PARQUE DE NEGOCIOS CENTRO 21 Lt.14 COL. ARENAL, C.P. 23460, CABO SAN LUCAS, B.C.S.', 'city_id' => 38, 'client_id' => 7]);
        Branch::create(['address' => 'RAFAEL BUELNA No.220, INFONAVIT PLAYAS, C.P 82128, MAZATLAN, SINALOA.', 'city_id' => 41, 'client_id' => 7]);
        Branch::create(['address' => 'AV. REPUBLICA DE PANAMA No. 190, COL. CUAUHTEMOC SUR, C.P. 21200, MEXICALI, B.C.', 'city_id' => 43, 'client_id' => 7]);
        Branch::create(['address' => 'BLVD. BENITO JUAREZ # 121 COL. EL PUEBLO, C.P.25730, MONCLOVA, COAHUILA.', 'city_id' => 44, 'client_id' => 7]);
        Branch::create(['address' => 'PROLONGACION MADERO No. 4305-A OTE. COL. FIERRO, C.P. 64590, MONTERREY, N.L. ', 'city_id' => 45, 'client_id' => 7]);
        Branch::create(['address' => 'GERTRUDIS BOCANEGRA No.1377, COL. VENTURA PUENTE C.P. 58020, MORELIA, MICHOACAN.', 'city_id' => 46, 'client_id' => 7]);
        Branch::create(['address' => 'JOSÉ DE ESCANDÓN # 2310, COL. GUERRERO, C.P. 88240, NUEVO LAREDO, TAMAULIPAS.', 'city_id' => 47, 'client_id' => 7]);
        Branch::create(['address' => 'MINA #109, PTE. COL. CENTRO,  C.P.26000,PIEDRAS NEGRAS, COAHUILA.', 'city_id' => 51, 'client_id' => 7]);
        Branch::create(['address' => 'MANGLE No. 547, COL. AGUA ZARCA, C.P. 48315, PUERTO VALLARTA JALISCO.', 'city_id' => 55, 'client_id' => 7]);
        Branch::create(['address' => 'ESPUELA DEL FERROCARRIL N. 204, COL. FELIPE CARRILLO PUERTO, C.P.76138, SANTIAGO DE QUERETARO, QRO. ', 'city_id' => 58, 'client_id' => 7]);
        Branch::create(['address' => 'FRANCISCO I. MADERO # 125, COL. BELLAVISTA, C.P. 88600, REYNOSA, TAMAULIPAS. ', 'city_id' => 59, 'client_id' => 7]);
        Branch::create(['address' => 'CALLE RAMÓN CORONA #507 ZONA CENTRO,  C.P. 25000,  SALTILLO,  COAHUILA.', 'city_id' => 61, 'client_id' => 7]);
        Branch::create(['address' => 'AV. FELIX CONTRERAS Y CALLE DIEZ No. 1001, COL. COMERCIAL, C.P. 83449, SAN LUIS RIO COLORADO, SON.', 'city_id' => 63, 'client_id' => 7]);
        Branch::create(['address' => 'BOULEVARD TEPIC-XALISCO No. 400, COL. LOS FRESNOS, C.P. 63190, TEPIC, NAYARIT', 'city_id' => 66, 'client_id' => 7]);
        Branch::create(['address' => 'CALLE ONCE No. 280 ZONA CENTRO, TIJUANA, BAJA CALIFORNIA NORTE.  C.P. 22000.', 'city_id' => 68, 'client_id' => 7]);
        Branch::create(['address' => 'VIA ALFREDO DEL MAZO NUM.342-B, ZONA INDUSTRIAL  C.P. 50200, TOLUCA, ESTADO DE MEXICO.', 'city_id' => 71, 'client_id' => 7]);
        Branch::create(['address' => 'BLVD. CARRETERA TORREON-MATAMOROS, #6068 OTE COL. EXHACIENDA LA MERCED, C.P. 27080, TORREON, COAHUILA.', 'city_id' => 72, 'client_id' => 7]);
        Branch::create(['address' => 'ARTEAGA No.467 COL. LA MAGDALENA C.P. 60080, URUAPAN, MICHOACAN.', 'city_id' => 77, 'client_id' => 7]);
        Branch::create(['address' => 'CANTERA No. 111, CONJUNTO INDUSTRIAL DE LA PLATA, C.P. 98615, GUADALUPE, ZACATECAS.', 'city_id' => 81, 'client_id' => 7]);
        Branch::create(['address' => 'VIRREY DE MENDOZA 248, COL. JARDINADAS, C.P. 59680, ZAMORA MICHOACAN.     ', 'city_id' => 82, 'client_id' => 7]);
        
        Branch::create(['address' => 'Dr. Navarro # 25, Col. Doctores, C.P.06720, Delegación Cuauhtémoc, CDMX.', 'city_id' => 11, 'client_id' => 11]);
        Branch::create(['address' => 'Av. Vallarta 6485, Col. Ciudad Granja, C.P. 45010, Zapopan, Jal.', 'city_id' => 83, 'client_id' => 11]);
        Branch::create(['address' => 'Av. Epigmenio Glez. #7, Col. Fracc. Parques Industriales, C.P. 76150, Querétaro, Qro.', 'city_id' => 58, 'client_id' => 11]);
        Branch::create(['address' => 'Cerrada de Galeana # 60, Fracc. Ind. La Loma, Tlalnep. Edo.Méx', 'city_id' => 69, 'client_id' => 11]);
        
        Branch::create(['address' => 'ARENAL #41 COL. ESPERANZA, ALCALDÍA CUAUHTEMOC', 'city_id' => 11, 'client_id' => 12]);

        Branch::create(['address' => 'Calle Centeno 90, Col. Granjas Esmeralda, C.P. 09810 CDMX. Alcaldía Iztapalapa, Tel: (0155) 5445-0500', 'city_id' => 13, 'client_id' => 10]);
        Branch::create(['address' => 'Av. de los Maestros # 408, Col. Nueva Santa María, Alcaldía Azcapotzalco C. P. 02800. Tel: (0155) 5341-5114', 'city_id' => 12, 'client_id' => 10]);
        Branch::create(['address' => '3era. Zona # 312, Col. Caracol. C.P. 64810 Monterrey, Nuevo León. Tel: (0181) 81-28-82-00', 'city_id' => 45, 'client_id' => 10]);
        Branch::create(['address' => 'Calle Motolinia No. 24, Col. Centro. C.P. 62000 Cuernavaca, Morelos, Cuernavaca. Tel: (01 777) 314-45-18 ó 23', 'city_id' => 23, 'client_id' => 10]);
        Branch::create(['address' => 'Av. Independencia No. 1900 L26, Col. Sta María Tepaltitlán. C.P. 57071 Toluca Estado de México, Tel 01(722) 199-7400; 199 7401; 199-7402', 'city_id' => 71, 'client_id' => 10]);
        Branch::create(['address' => 'Calle Zacatecas 140-B; Col. Los Pinos. C.P. 25720. Monclova,Coahuila. Tel: (01866) 634-33-77, Tel: (01866) 634-33-78, Tel: (01866) 635-32-60, Tel: (01866) 635-13-75', 'city_id' => 44, 'client_id' => 10]);
        Branch::create(['address' => 'Av. Lázaro Cárdenas 2596-C, Col. Vista Hermosa, C.P. 26060. Piedras Negras Coah.Tel: (01878) 783-9523', 'city_id' => 51, 'client_id' => 10]);
        Branch::create(['address' => 'Boulevard V. Carranza #2949-1, Col. La Salle C.P.25240. Saltillo, Coahuila.Tel: 01(844) 415-56-15; 415-7877; 415-1591', 'city_id' => 61, 'client_id' => 10]);
        Branch::create(['address' => 'Calz. Netzahualcoyotl No. 2479, Col. Moctezuma. C.P. 27030 Torreón Coah.Tel: 01(871) 713-9102; 713-9302; 713-2200; 718-7901', 'city_id' => 72, 'client_id' => 10]);
        Branch::create(['address' => 'Av. Washington #55, Col. San Carlos, TEL. (01)33 36501515; 0133-36500531; ', 'city_id' => 28, 'client_id' => 10]);
        Branch::create(['address' => 'Cipres No. 717, Col. Granjas; C.P. 31160, Chihuahua  Chih. Tel: 01(614) 417-1777;421-9700; 421-9702', 'city_id' => 16, 'client_id' => 10]);
        Branch::create(['address' => 'Ave. 20 poniente No. 708, Col. Sector Pte.CP 33000, Delicias, Chih. Tel: 01 639 4748633', 'city_id' => 24, 'client_id' => 10]);
        Branch::create(['address' => 'Hermanos Aldama 652, Col. Barrio de Santiago, C.P. 37000 León, Gto. Tel: 01(477) 718-6710, 716-5556', 'city_id' => 37, 'client_id' => 10]);
        Branch::create(['address' => 'Periférico Carlos Pellicer Cámara Num. 659-A. Col. Miguel Hidalgo. Villahermosa Tabasco', 'city_id' => 79, 'client_id' => 10]);
        Branch::create(['address' => 'Calle Parcela #202, Col. Rojo Gómez, CP 42030, Pachuca de Soto, Hidalgo. Tel: 01 (771) 153 1198', 'city_id' => 50, 'client_id' => 10]);
        Branch::create(['address' => 'Av. Mar Mediterráneo #770, Col. Alemán, CP. 22050. Tijuana, B.C. Tel: 01(664) 6872320 ', 'city_id' => 68, 'client_id' => 10]);
        Branch::create(['address' => 'Av. De la Patria No. 900, Col. Centro Cívico, C.P. 21000 Mexicali B.C. Tel: 01(686) 838-7600', 'city_id' => 43, 'client_id' => 10]);

        Branch::create(['address' => 'Centeno 377C, Granjas México, Iztacalco, 08400 Ciudad de México, CDMX', 'city_id' => 11, 'client_id' => 7]);
        Branch::create(['address' => 'Av. 12 Ote. 3208 Col, Zona Sin Asignación de Nombre de Col 41, Resurgimiento Cd. Nte, 09030 Heroica Puebla de Zaragoza, Pue.', 'city_id' => 56, 'client_id' => 7]);
        Branch::create(['address' => 'Calzada Manuel Clouthier 5274, Colonia Campestre, Las Bajadas, 91775 Veracruz, Ver.', 'city_id' => 78, 'client_id' => 7]);
        Branch::create(['address' => 'Niño Perdido 331, Delegación Santa María Totoltepec, 52120 San Pedro Totoltepec, Méx.', 'city_id' => 71, 'client_id' => 7]);

        Branch::create(['address' => 'calzada Legaria 691, Col. Irrigación, C.P. 11500 México, D.F.', 'city_id' => 85, 'client_id' => 3]);
        Branch::create(['address' => 'calzada Legaria 691, Col. Irrigación, C.P. 11500 México, D.F.', 'city_id' => 86, 'client_id' => 3]);
        Branch::create(['address' => 'Parque Industrial Guadalajara Prolongación Gobernador Curiel # 5000 Las Pintas, El Salto Jalisco C.P 45690', 'city_id' => 87, 'client_id' => 3]);
        Branch::create(['address' => 'Parque Industrial Guadalajara Prolongación Gobernador Curiel # 5000 Las Pintas, El Salto Jalisco C.P 45690', 'city_id' => 88, 'client_id' => 3]);
        Branch::create(['address' => 'Carretera Miguel Alemán No. 770 Complejo Industrial Kalos, Apodaca Nuevo Leon. 66603 México', 'city_id' => 89, 'client_id' => 3]);
        Branch::create(['address' => 'Paseo de los Álamos No. 226 Col Casa Grande Hermosillo Sonora', 'city_id' => 90, 'client_id' => 3]);
        Branch::create(['address' => 'Boulevard Adolfo Ruiz Cortínez No. 1700 Fraccionamiento Costa de Oro. C,P 92499 Boca del Rio, Veracruz', 'city_id' => 91, 'client_id' => 3]);
        Branch::create(['address' => 'Calle 56A No.475x37 Paseo Montejo, Mérida Yucatán. 97000 México', 'city_id' => 92, 'client_id' => 3]);
    }
}
