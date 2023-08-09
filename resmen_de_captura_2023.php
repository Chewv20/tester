<HTML><HEAD>
<TITLE>Resumen de Captura de averías CC</TITLE>
<!-- refrescar la ventana cada 5 segundos -->
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
<META HTTP-EQUIV="refresh" content="120">
<BODY>
<center>
<?php
$periodo = 2023;
$periodo2=$periodo-1;
$anio=substr($periodo,-2);
$anio2=substr($periodo2,-2);
//$archivo_r="reporte_$anio";
$archivo_r="reportes";
//$archivo_i="intervencion_$anio";
$archivo_i="intervenciones";
$archivo_i2="intervencion_$anio2";

//include("connect.php");
$identifier="AVESTC";
include "../connect.php";

$query="select fecha, sum(l1) as l1, sum(l2) as l2, sum(l3) as l3, sum(l4) as l4, sum(l5) as l5, sum(l6) as l6, sum(l7) as l7, sum(l8) as l8,
       sum(l9) as l9, sum(la) as la, sum(lb) as lb, sum(tot) as total from
(
select fecha,
       case when origen='CC01' then 1 else 0 end as l1,
       case when origen='CC02' then 1 else 0 end as l2,
       case when origen='CC03' then 1 else 0 end as l3,
       case when origen='CC04' then 1 else 0 end as l4,
       case when origen='CC05' then 1 else 0 end as l5,
       case when origen='CC06' then 1 else 0 end as l6,
       case when origen='CC07' then 1 else 0 end as l7,
       case when origen='CC08' then 1 else 0 end as l8,
       case when origen='CC09' then 1 else 0 end as l9,
       case when origen='CCLA' then 1 else 0 end as la,
       case when origen='CCLB' then 1 else 0 end as lb,
       1 as tot
from reportes where extract(year from fecha)=$periodo) as filtro
group by fecha order by fecha desc";

//from $archivo_r where extract(year from fec_reporte)=$periodo) as filtro
//origen_reporte
//echo pg_host($conn_a)."<br>";

$resultado=pg_exec($conn_a,$query);
echo "<h1>Reportes de Averias CC</h1>";
echo "<table border=0>\n<tr>\n<td align=center valign=top>\n<h2>Resumen Diario por Linea</h2>";
echo "<table border=1>\n<tr align=center>\n<td><font size=2><strong>FECHA<td><font size=2><strong>L-1<td><font size=2><strong>L-2<td><font size=2><strong>L-3<td><font size=2><strong>L-4<td><font size=2><strong>L-5<td><font size=2><strong>L-6<td><font size=2><strong>L-7<td><font size=2><strong>L-8<td><font size=2><strong>L-9<td><font size=2><strong>L-A<td><font size=2><strong>L-B<td><font size=2><strong> TOTAL</td></tr>\n";
$t1=$t2=$t3=$t4=$t5=$t6=$t7=$t8=$t9=$ta=$tb=$tt=0;
for ($i=0;$i<pg_numrows($resultado);$i++){
    echo "<tr align=right>\n";
    echo "<td>".pg_result($resultado,$i,fecha)."</td>";
    echo "<td ".(pg_result($resultado,$i,l1)==0 ? "bgcolor=yellow" : "").">".pg_result($resultado,$i,l1)."</td>";
    echo "<td ".(pg_result($resultado,$i,l2)==0 ? "bgcolor=yellow" : "").">".pg_result($resultado,$i,l2)."</td>";
    echo "<td ".(pg_result($resultado,$i,l3)==0 ? "bgcolor=yellow" : "").">".pg_result($resultado,$i,l3)."</td>";
    echo "<td ".(pg_result($resultado,$i,l4)==0 ? "bgcolor=yellow" : "").">".pg_result($resultado,$i,l4)."</td>";
    echo "<td ".(pg_result($resultado,$i,l5)==0 ? "bgcolor=yellow" : "").">".pg_result($resultado,$i,l5)."</td>";
    echo "<td ".(pg_result($resultado,$i,l6)==0 ? "bgcolor=yellow" : "").">".pg_result($resultado,$i,l6)."</td>";
    echo "<td ".(pg_result($resultado,$i,l7)==0 ? "bgcolor=yellow" : "").">".pg_result($resultado,$i,l7)."</td>";
    echo "<td ".(pg_result($resultado,$i,l8)==0 ? "bgcolor=yellow" : "").">".pg_result($resultado,$i,l8)."</td>";
    echo "<td ".(pg_result($resultado,$i,l9)==0 ? "bgcolor=yellow" : "").">".pg_result($resultado,$i,l9)."</td>";
    echo "<td ".(pg_result($resultado,$i,la)==0 ? "bgcolor=yellow" : "").">".pg_result($resultado,$i,la)."</td>";
    echo "<td ".(pg_result($resultado,$i,lb)==0 ? "bgcolor=yellow" : "").">".pg_result($resultado,$i,lb)."</td>";
    echo "<td ".(pg_result($resultado,$i,total)==0 ? "bgcolor=yellow" : "").">".pg_result($resultado,$i,total)."</td>";
    $t1+=pg_result($resultado,$i,l1);
    $t2+=pg_result($resultado,$i,l2);
    $t3+=pg_result($resultado,$i,l3);
    $t4+=pg_result($resultado,$i,l4);
    $t5+=pg_result($resultado,$i,l5);
    $t6+=pg_result($resultado,$i,l6);
    $t7+=pg_result($resultado,$i,l7);
    $t8+=pg_result($resultado,$i,l8);
    $t9+=pg_result($resultado,$i,l9);
    $ta+=pg_result($resultado,$i,la);
    $tb+=pg_result($resultado,$i,lb);
    $tt+=pg_result($resultado,$i,total);
    echo "\n</tr>\n";
}
echo "<tr align=right>\n";
echo "<td><font size=2><strong>TOTAL</td>";
echo "<td><font size=2><strong>$t1</td>";
echo "<td><font size=2><strong>$t2</td>";
echo "<td><font size=2><strong>$t3</td>";
echo "<td><font size=2><strong>$t4</td>";
echo "<td><font size=2><strong>$t5</td>";
echo "<td><font size=2><strong>$t6</td>";
echo "<td><font size=2><strong>$t7</td>";
echo "<td><font size=2><strong>$t8</td>";
echo "<td><font size=2><strong>$t9</td>";
echo "<td><font size=2><strong>$ta</td>";
echo "<td><font size=2><strong>$tb</td>";
echo "<td><font size=2><strong>$tt</td>";
echo "</tr></table><br><br><br>\n";
echo "</td><td align=center valign=top>\n";


echo "<h2>Registros de Reportes por Capturista...</h2>\n";

// agregar a un prestador  o trabajador para que aparesca en la estadistica
//insert into plantilla2 (expediente, nombre,usuario, password) values (81574, 'IRVIN JAFET PALACIOS CABALLERO','PALACIOS','81574') 

//$resultado1=pg_exec($conn_a,"select registra, count(*) as hay from $archivo_r where extract(year from fec_ulrepo)=$periodo  group by registra order by hay desc");
$resultado1=pg_exec($conn_a,"select usu_alta, count(*) as hay from reportes where extract(year from fec_alta)=$periodo  AND USU_ALTA<>81572 AND USU_ALTA<>81567 AND USU_ALTA<>81570 AND USU_ALTA<>81569  AND USU_ALTA<>81571  group by usu_alta order by hay desc");
//echo "select usu_alta, count(*) as hay from reportes where extract(year from fec_alta)=$periodo  AND USU_ALTA<>81572 AND USU_ALTA<>81567 AND USU_ALTA<>81570 AND USU_ALTA<>81569  AND USU_ALTA<>81571  group by usu_alta order by hay desc";
//$resultado10=pg_exec($conn_a,"select concat(plantilla2.nombre,' ', plantilla2.usuario) as usu_alta,  count(*) as hay from reportes inner join plantilla2 on (plantilla2.expediente = reportes.usu_alta) where extract(year from reportes.fec_alta)=$periodo  AND plantilla2.usuario<>'TORREA' AND plantilla2.usuario<>'ISMAELB' AND plantilla2.usuario<>'ADAMARIS' AND plantilla2.usuario<>'MTORRES'  group by plantilla2.usuario, plantilla2.nombre order by hay desc");
$resultado10=pg_exec($conn_a,"select concat(plantilla2.nombre,' ', plantilla2.usuario) as usu_alta,  count(*) as hay from reportes inner join plantilla2 on (plantilla2.expediente = reportes.usu_alta) where extract(year from reportes.fec_alta)=$periodo  group by plantilla2.usuario, plantilla2.nombre order by hay desc");
//echo "select plantilla2.usuario, count(*) as hay from reportes inner join plantilla2 on (plantilla2.expediente = reportes.usu_alta) where extract(year from reportes.fec_alta)=$periodo  group by plantilla2.usuario order by hay desc";

for ($i=0;$i<pg_numrows($resultado10);$i++) $usu_alta[$i]=chop(pg_result($resultado10,$i,usu_alta));
for ($i=0;$i<pg_numrows($resultado1);$i++) $usu[$i]=chop(pg_result($resultado1,$i,usu_alta));
for ($i=0;$i<pg_numrows($resultado1);$i++) $usua[$i]="us$i";
$query="select fecha ";
for ($i=0;$i<pg_numrows($resultado1);$i++) $query.=",sum(us$i) as us$i";
$query.=",  sum(tot) as total from
(
select fec_alta as fecha, ";
for ($i=0;$i<pg_numrows($resultado1);$i++) $query.="case when usu_alta='".$usu[$i]."' then 1 else 0 end as us$i, ";
$query.=" 1 as tot
from reportes where extract(year from fec_alta)=$periodo) as filtro
group by fecha order by fecha desc
";
//echo $query;
echo "<table border=1>\n<tr align= center>\n";
echo "<td><font size=2><strong>Nó</td><td><font size=2><strong>FECHA</td>";
//for ($i=0;$i<pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".$usu[$i]."</td>\n";
for ($i=0;$i<pg_numrows($resultado10);$i++){
    $usuario_captura=$usu_alta[$i];
    //echo "<td><font size=2><strong>".$usu_alta[$i]."</td>\n";
    /*if ($usuario_captura=='FLORES NERIA ETZON YOSIMAR YOSIMAR') {
        echo "<td><font size=2><strong> KARLA REYES</td>\n";    
    }ELSE{
        echo "<td><font size=2><strong>".$usuario_captura."</td>\n";
    }*/
    echo "<td><font size=2><strong>".$usuario_captura."</td>\n";    
}

echo "<td><font size=2><strong>Total</td>\n";
echo "</tr>";
$resultado2=pg_exec($conn_a,$query);
for ($i=0;$i<=pg_numrows($resultado1);$i++) $t[$i]=0;
for ($j=0;$j<pg_numrows($resultado2);$j++){
    $k=$j+1;
    echo "<tr align=right>\n";
    echo "<td align=center>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").$k."</td>\n";
    echo "<td align=center>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,fecha)."</td>\n";
    for ($i=0;$i<pg_numrows($resultado1);$i++){
        if(pg_result($resultado2,$j,$usua[$i])<50){
            echo "<td bgcolor=FF5757 align=center>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,$usua[$i])."</td>\n";
            $t[$i]+=pg_result($resultado2,$j,$usua[$i]);
        }
        elseif(pg_result($resultado2,$j,$usua[$i])> 49 && pg_result($resultado2,$j,$usua[$i])<80){
            echo "<td bgcolor=FFF776 align=center>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,$usua[$i])."</td>\n";
            $t[$i]+=pg_result($resultado2,$j,$usua[$i]);
        }else{
            echo "<td bgcolor=80C178 align=center>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,$usua[$i])."</td>\n";
            $t[$i]+=pg_result($resultado2,$j,$usua[$i]);
        }
    }
    $i=pg_numrows($resultado1);
    $t[$i]+=pg_result($resultado2,$j,total);
    echo "<td align=center>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,total)."</td>\n";
    echo "</tr>\n";
}
//echo "<tr align=right>\n";
//echo "<td colspan=2><font size=2><strong>Total.</td>\n";
//for ($i=0;$i<=pg_numrows($resultado1);$i++)$t[$i]+=pg_numrows($resultado2);
//for ($i=0;$i<=pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".number_format($t[$i],0)."</td>\n";
echo "<tr align=right>\n";
echo "<td colspan=2><font size=2><strong>Prom.</td>\n";
for ($i=0;$i<=pg_numrows($resultado1);$i++)$t[$i]/=pg_numrows($resultado2);
for ($i=0;$i<=pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".number_format($t[$i],1)."</td>\n";
echo "</table><br><br><br>\n";


echo "<h2>Reportes Modificados por Capturista </h2>\n";
//$resultado1=pg_exec($conn_a,"select usu_mod as modifica, count(*) as hay from $archivo_r where extract(year from fec_mod)=$periodo  group by usu_mod order by hay desc");
//echo "select modifica, count(*) as hay from $archivo_r where extract(year from fec_ulmodi)=$periodo  group by modifica order by hay desc";
$resultado1=pg_exec($conn_a,"select usu_mod as modifica, count(*) as hay, plantilla2.usuario as nombre from reportes inner join plantilla2 on (plantilla2.expediente = reportes.usu_mod) where extract(year from reportes.fec_mod)=$periodo group by usu_mod, plantilla2.usuario order by hay desc");
for ($i=0;$i<pg_numrows($resultado1);$i++) $usu[$i]=chop(pg_result($resultado1,$i,modifica));
for ($i=0;$i<pg_numrows($resultado1);$i++) $nombre[$i]=chop(pg_result($resultado1,$i,nombre));
for ($i=0;$i<pg_numrows($resultado1);$i++) $usua[$i]="us$i";
$query="select fecha ";
for ($i=0;$i<pg_numrows($resultado1);$i++) $query.=",sum(us$i) as us$i";
$query.=",  sum(tot) as total from
(
select fec_mod as fecha, ";
for ($i=0;$i<pg_numrows($resultado1);$i++) $query.="case when usu_mod='".$usu[$i]."' then 1 else 0 end as us$i, ";
$query.=" 1 as tot
from $archivo_r where extract(year from fec_mod)=$periodo) as filtro
group by fecha order by fecha desc
";
//echo $query;
echo "<table border=1>\n<tr align= center>\n";
echo "<td><font size=2><strong>Nó</td><td><font size=2><strong>FECHA</td>";
//for ($i=0;$i<pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".$usu[$i]."</td>\n";
for ($i=0;$i<pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".$nombre[$i]."</td>\n";
echo "<td><font size=2><strong>Total</td>\n";
echo "</tr>";
$resultado2=pg_exec($conn_a,$query);
for ($i=0;$i<=pg_numrows($resultado1);$i++) $t[$i]=0;
for ($j=0;$j<pg_numrows($resultado2);$j++){
    $k=$j+1;
    echo "<tr align=right>\n";
    echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").$k."</td>\n";
    echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,fecha)."</td>\n";
    for ($i=0;$i<pg_numrows($resultado1);$i++){
	 echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,$usua[$i])."</td>\n";
	 $t[$i]+=pg_result($resultado2,$j,$usua[$i]);
    }
    $i=pg_numrows($resultado1);
    $t[$i]+=pg_result($resultado2,$j,total);
    echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,total)."</td>\n";
    echo "</tr>\n";
}
echo "<tr align=right>\n";
echo "<td colspan=2><font size=2><strong>Total.</td>\n";
for ($i=0;$i<=pg_numrows($resultado1);$i++)$t[$i]+=pg_numrows($resultado2);
for ($i=0;$i<=pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".number_format($t[$i],0)."</td>\n";
echo "<tr align=right>\n";
echo "<td colspan=2><font size=2><strong>Prom.</td>\n";
for ($i=0;$i<=pg_numrows($resultado1);$i++)$t[$i]/=pg_numrows($resultado2);
for ($i=0;$i<=pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".number_format($t[$i],1)."</td>\n";
echo "</table></table><br><br><br>\n";








/*
$query="select fecha, sum(l1) as l1, sum(l2) as l2, sum(l3) as l3, sum(l4) as l4, sum(l5) as l5, sum(l6) as l6, sum(l7) as l7, sum(l8) as l8,
       sum(l9) as l9, sum(la) as la, sum(lb) as lb, sum(tot) as total from
(
select fecha,
       case when substr(linea,2,1)='1' then 1 else 0 end as l1,
       case when substr(linea,2,1)='2' then 1 else 0 end as l2,
       case when substr(linea,2,1)='3' then 1 else 0 end as l3,
       case when substr(linea,2,1)='4' then 1 else 0 end as l4,
       case when substr(linea,2,1)='5' then 1 else 0 end as l5,
       case when substr(linea,2,1)='6' then 1 else 0 end as l6,
       case when substr(linea,2,1)='7' then 1 else 0 end as l7,
       case when substr(linea,2,1)='8' then 1 else 0 end as l8,
       case when substr(linea,2,1)='9' then 1 else 0 end as l9,
       case when substr(linea,2,1)='A' then 1 else 0 end as la,
       case when substr(linea,2,1)='B' then 1 else 0 end as lb,
       1 as tot
from $archivo_r where extract(year from fec_reporte)=$periodo) as filtro
group by fecha order by fecha";
$resultado=pg_exec($conn_a,$query);
*/
echo "<h1>Avisos de Atencion </h1>";
/*
echo "<table border=0>\n<tr>\n<td align=center>\n<h2>Resumen Diario por L�nea</h2>";
echo "<table border=1>\n<tr align=center>\n<td><font size=2><strong>FECHA<td><font size=2><strong>L-1<td><font size=2><strong>L-2<td><font size=2><strong>L-3<td><font size=2><strong>L-4<td><font size=2><strong>L-5<td><font size=2><strong>L-6<td><font size=2><strong>L-7<td><font size=2><strong>L-8<td><font size=2><strong>L-9<td><font size=2><strong>L-A<td><font size=2><strong>L-B<td><font size=2><strong> TOTAL</td></tr>\n";
$t1=$t2=$t3=$t4=$t5=$t6=$t7=$t8=$t9=$ta=$tb=$tt=0;
for ($i=1;$i<pg_numrows($resultado);$i++){
    echo "<tr align=right>\n";
    echo "<td>".pg_result($resultado,$i,fecha)."</td>";
    echo "<td>".pg_result($resultado,$i,l1)."</td>";
    echo "<td>".pg_result($resultado,$i,l2)."</td>";
    echo "<td>".pg_result($resultado,$i,l3)."</td>";
    echo "<td>".pg_result($resultado,$i,l4)."</td>";
    echo "<td>".pg_result($resultado,$i,l5)."</td>";
    echo "<td>".pg_result($resultado,$i,l6)."</td>";
    echo "<td>".pg_result($resultado,$i,l7)."</td>";
    echo "<td>".pg_result($resultado,$i,l8)."</td>";
    echo "<td>".pg_result($resultado,$i,l9)."</td>";
    echo "<td>".pg_result($resultado,$i,la)."</td>";
    echo "<td>".pg_result($resultado,$i,lb)."</td>";
    echo "<td>".pg_result($resultado,$i,total)."</td>";
    $t1+=pg_result($resultado,$i,l1);
    $t2+=pg_result($resultado,$i,l2);
    $t3+=pg_result($resultado,$i,l3);
    $t4+=pg_result($resultado,$i,l4);
    $t5+=pg_result($resultado,$i,l5);
    $t6+=pg_result($resultado,$i,l6);
    $t7+=pg_result($resultado,$i,l7);
    $t8+=pg_result($resultado,$i,l8);
    $t9+=pg_result($resultado,$i,l9);
    $ta+=pg_result($resultado,$i,la);
    $tb+=pg_result($resultado,$i,lb);
    $tt+=pg_result($resultado,$i,total);
    echo "\n</tr>\n";
}
echo "<tr align=right>\n";
echo "<td><font size=2><strong>TOTAL</td>";
echo "<td><font size=2><strong>$t1</td>";
echo "<td><font size=2><strong>$t2</td>";
echo "<td><font size=2><strong>$t3</td>";
echo "<td><font size=2><strong>$t4</td>";
echo "<td><font size=2><strong>$t5</td>";
echo "<td><font size=2><strong>$t6</td>";
echo "<td><font size=2><strong>$t7</td>";
echo "<td><font size=2><strong>$t8</td>";
echo "<td><font size=2><strong>$t9</td>";
echo "<td><font size=2><strong>$ta</td>";
echo "<td><font size=2><strong>$tb</td>";
echo "<td><font size=2><strong>$tt</td>";
echo "</tr></table><br><br><br>\n";
*/
echo "</td><td align=center valign=top>\n";


echo "<h2>Registros de Avisos de Intervención por Capturista... </h2>\n";
//$resultado1=pg_exec($conn_a,"select registra, count(*) as hay from $archivo_i where extract(year from fec_ulrepo)=$periodo group by registra order by hay desc");
$resultado1=pg_exec($conn_a,"select usu_alta as registra, count(*) as hay,plantilla2.usuario as nombre from intervenciones inner join plantilla2 on (plantilla2.expediente = intervenciones.usu_alta) where extract(year from fecha)=2023 group by registra, plantilla2.usuario order by hay desc");
//echo "select usu_alta as registra, count(*) as hay,plantilla2.usuario as nombre from intervenciones inner join plantilla2 on (plantilla2.expediente = intervenciones.usu_alta) where extract(year from fecha)=2023 group by registra, plantilla2.usuario order by hay desc";
//echo "select usu_alta as registra, count(*) as hay,plantilla2.usuario as nombre from intervenciones inner join plantilla2 on (plantilla2.expediente = intervenciones.usu_alta) where extract(year from fecha)=2018 group by registra, plantilla2.usuario order by hay desc";
//echo "select registra, count(*) as hay from $archivo_i where extract(year from fec_ulrepo)=$periodo group by registra order by hay desc";
for ($i=0;$i<pg_numrows($resultado1);$i++) $usu[$i]=chop(pg_result($resultado1,$i,registra));
for ($i=0;$i<pg_numrows($resultado1);$i++) $usua[$i]="us$i";
for ($i=0;$i<pg_numrows($resultado1);$i++) $nombre[$i]=chop(pg_result($resultado1,$i,nombre));
$query="select fecha ";
for ($i=0;$i<pg_numrows($resultado1);$i++) $query.=",sum(us$i) as us$i";
$query.=",  sum(tot) as total from
(
select fecha as fecha, ";
for ($i=0;$i<pg_numrows($resultado1);$i++) $query.="case when usu_alta='".$usu[$i]."' then 1 else 0 end as us$i, ";
$query.=" 1 as tot
from $archivo_i where extract(year from fecha)=$periodo) as filtro
group by fecha order by fecha desc
";
//echo $query;
echo "<table border=1>\n<tr align= center>\n";
echo "<td><font size=2><strong>Nó</td><td><font size=2><strong>FECHA</td>";
for ($i=0;$i<pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".$nombre[$i]."</td>\n";
echo "<td><font size=2><strong>Total</td>\n";
echo "</tr>";
$resultado2=pg_exec($conn_a,$query);
for ($i=0;$i<=pg_numrows($resultado1);$i++) $t[$i]=0;
for ($j=0;$j<pg_numrows($resultado2);$j++){
    $k=$j+1;
    echo "<tr align=right>\n";
    echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").$k."</td>\n";
    echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,fecha)."</td>\n";
    for ($i=0;$i<pg_numrows($resultado1);$i++){
	 echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,$usua[$i])."</td>\n";
	 $t[$i]+=pg_result($resultado2,$j,$usua[$i]);
    }
    $i=pg_numrows($resultado1);
    $t[$i]+=pg_result($resultado2,$j,total);
    echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,total)."</td>\n";
    echo "</tr>\n";
}
echo "<tr align=right>\n";
echo "<td colspan=2><font size=2><strong>Total.</td>\n";
for ($i=0;$i<=pg_numrows($resultado1);$i++)$t[$i]+=pg_numrows($resultado2);
for ($i=0;$i<=pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".number_format($t[$i],0)."</td>\n";
echo "<tr align=right>\n";
echo "<td colspan=2><font size=2><strong>Prom.</td>\n";
for ($i=0;$i<=pg_numrows($resultado1);$i++)$t[$i]/=pg_numrows($resultado2);
for ($i=0;$i<=pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".number_format($t[$i],1)."</td>\n";
echo "</table><br><br><br>\n";


/*echo "<h2>Reportes de Aviso de Intervenci�n del $periodo2 Actualizados por Capturista</h2>\n";
$resultado1=pg_exec($conn_a,"select modifica, count(*) as hay from $archivo_i2 where extract(year from fec_ulmodi)=$periodo  group by modifica order by hay desc");
for ($i=0;$i<pg_numrows($resultado1);$i++) $usu[$i]=chop(pg_result($resultado1,$i,modifica));
for ($i=0;$i<pg_numrows($resultado1);$i++) $usua[$i]="us$i";
$query="select fecha ";
for ($i=0;$i<pg_numrows($resultado1);$i++) $query.=",sum(us$i) as us$i";
$query.=",  sum(tot) as total from
(
select fec_ulmodi as fecha, ";
for ($i=0;$i<pg_numrows($resultado1);$i++) $query.="case when modifica='".$usu[$i]."' then 1 else 0 end as us$i, ";
$query.=" 1 as tot
from $archivo_i2 where extract(year from fec_ulmodi)=$periodo) as filtro
group by fecha order by fecha desc
";
//echo $query;
echo "<table border=1>\n<tr align= center>\n";
echo "<td><font size=2><strong>N�</td><td><font size=2><strong>FECHA</td>";
for ($i=0;$i<pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".$usu[$i]."</td>\n";
echo "<td><font size=2><strong>Total</td>\n";
echo "</tr>";
$resultado2=pg_exec($conn_a,$query);
for ($i=0;$i<=pg_numrows($resultado1);$i++) $t[$i]=0;
for ($j=0;$j<pg_numrows($resultado2);$j++){
    $k=$j+1;
    echo "<tr align=right>\n";
    echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").$k."</td>\n";
    echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,fecha)."</td>\n";
    for ($i=0;$i<pg_numrows($resultado1);$i++){
	 echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,$usua[$i])."</td>\n";
	 $t[$i]+=pg_result($resultado2,$j,$usua[$i]);
    }
    $i=pg_numrows($resultado1);
    $t[$i]+=pg_result($resultado2,$j,total);
    echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,total)."</td>\n";
    echo "</tr>\n";
}
echo "<tr align=right>\n";
echo "<td colspan=2><font size=2><strong>Total.</td>\n";
for ($i=0;$i<=pg_numrows($resultado1);$i++)$t[$i]+=pg_numrows($resultado2);
for ($i=0;$i<=pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".number_format($t[$i],0)."</td>\n";
echo "<tr align=right>\n";
echo "<td colspan=2><font size=2><strong>Prom.</td>\n";
for ($i=0;$i<=pg_numrows($resultado1);$i++)$t[$i]/=pg_numrows($resultado2);
for ($i=0;$i<=pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".number_format($t[$i],1)."</td>\n";
echo "</table><br><br><br>\n";

*/


echo "<h2>Reportes de Aviso de Intervención del $periodo Actualizados por Capturista... </h2>\n";
//$resultado1=pg_exec($conn_a,"select modifica, count(*) as hay from $archivo_i where extract(year from fec_ulmodi)=$periodo  group by modifica order by hay desc");
$resultado1=pg_exec($conn_a,"select usu_mod as modifica, count(*) as hay,plantilla2.usuario as nombre from intervenciones inner join plantilla2 on (plantilla2.expediente = intervenciones.usu_mod) where extract(year from intervenciones.fec_mod)=2023 group by modifica, plantilla2.usuario order by hay desc");
//echo "select usu_mod as modifica, count(*) as hay,plantilla2.usuario as nombre from intervenciones inner join plantilla2 on (plantilla2.expediente = intervenciones.usu_mod) where extract(year from intervenciones.fec_mod)=2023 group by modifica, plantilla2.usuario order by hay desc";


//echo "select usu_mod as modifica, count(*) as hay,plantilla2.usuario as nombre from intervenciones inner join plantilla2 on (plantilla2.expediente = intervenciones.usu_mod) where extract(year from intervenciones.fec_mod)=2018 group by modifica, plantilla2.usuario order by hay desc";
for ($i=0;$i<pg_numrows($resultado1);$i++) $usu[$i]=chop(pg_result($resultado1,$i,modifica));
for ($i=0;$i<pg_numrows($resultado1);$i++) $usua[$i]="us$i";
for ($i=0;$i<pg_numrows($resultado1);$i++) $nombre[$i]=chop(pg_result($resultado1,$i,nombre));
$query="select fecha ";
for ($i=0;$i<pg_numrows($resultado1);$i++) $query.=",sum(us$i) as us$i";
$query.=",  sum(tot) as total from
(
select fec_mod as fecha, ";
for ($i=0;$i<pg_numrows($resultado1);$i++) $query.="case when usu_mod='".$usu[$i]."' then 1 else 0 end as us$i, ";
$query.=" 1 as tot
from intervenciones where extract(year from fec_mod)=$periodo) as filtro
group by fecha order by fecha desc
";
//select fec_ulmodi as fecha, ";
//echo $query;
echo "<table border=1>\n<tr align= center>\n";
echo "<td><font size=2><strong>Nó</td><td><font size=2><strong>FECHA</td>";
for ($i=0;$i<pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".$nombre[$i]."</td>\n";
echo "<td><font size=2><strong>Total</td>\n";
echo "</tr>";
$resultado2=pg_exec($conn_a,$query);
for ($i=0;$i<=pg_numrows($resultado1);$i++) $t[$i]=0;
for ($j=0;$j<pg_numrows($resultado2);$j++){
    $k=$j+1;
    echo "<tr align=right>\n";
    echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").$k."</td>\n";
    echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,fecha)."</td>\n";
    for ($i=0;$i<pg_numrows($resultado1);$i++){
	 echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,$usua[$i])."</td>\n";
	 $t[$i]+=pg_result($resultado2,$j,$usua[$i]);
    }
    $i=pg_numrows($resultado1);
    $t[$i]+=pg_result($resultado2,$j,total);
    echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,total)."</td>\n";
    echo "</tr>\n";
}
echo "<tr align=right>\n";
//echo "<td colspan=2><font size=2><strong>Total.</td>\n";
//for ($i=0;$i<=pg_numrows($resultado1);$i++)$t[$i]+=pg_numrows($resultado2);
//for ($i=0;$i<=pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".number_format($t[$i],0)."</td>\n";
echo "<tr align=right>\n";
echo "<td colspan=2><font size=2><strong>Prom.</td>\n";
for ($i=0;$i<=pg_numrows($resultado1);$i++)$t[$i]/=pg_numrows($resultado2);
for ($i=0;$i<=pg_numrows($resultado1);$i++) echo "<td><font size=2><strong>".number_format($t[$i],1)."</td>\n";
echo "</table><br><br><br>\n";
