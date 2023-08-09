<HTML><HEAD>
<TITLE>Resumen de Captura de averías MR 2023 ULIK</TITLE>
<META HTTP-EQUIV="refresh" content="60">
<META charset="UTF-8">
<style>
    body{
        width:99%;
        left: 0;
        font-family: 'Open Sans';
    }
</style>

<BODY>
    <center>
    <?php

    $z=0;
    $identifier="AVEMR";
    include('../connect.php');
    for ($z=1;$z<=1; $z++){
    $origen=($z==1 ?"DU":"AN");
    $query="select fecha, sum(l1) as l1, sum(l2) as l2, sum(l3) as l3, sum(l4) as l4, sum(l5) as l5, sum(l6) as l6, sum(l7) as l7, sum(l8) as l8,
           sum(l9) as l9, sum(la) as la, sum(lb) as lb, sum(tot) as total from
        (
        select fecha,
               case when substr(estacion,2,1)='1' then 1 else 0 end as l1,
               case when substr(estacion,2,1)='2' then 1 else 0 end as l2,
               case when substr(estacion,2,1)='3' then 1 else 0 end as l3,
               case when substr(estacion,2,1)='4' then 1 else 0 end as l4,
               case when substr(estacion,2,1)='5' then 1 else 0 end as l5,
               case when substr(estacion,2,1)='6' then 1 else 0 end as l6,
               case when substr(estacion,2,1)='7' then 1 else 0 end as l7,
               case when substr(estacion,2,1)='8' then 1 else 0 end as l8,
               case when substr(estacion,2,1)='9' then 1 else 0 end as l9,
               case when substr(estacion,2,1)='A' then 1 else 0 end as la,
               case when substr(estacion,2,1)='B' then 1 else 0 end as lb,
               1 as tot
        from reportes where extract(year from fecha)=2023 and origen='$origen'
        ) as filtro
        group by fecha order by fecha desc
        ";
    //echo $query;
    $resultado=pg_exec($conn_a,$query);
    echo "<h1>Resumen de reportes capturados ".($z==1 ? 'Durante el servicio' : 'Antes del inicio')."</h1>";
    echo "<table border=0>\n<tr>\n<td align=center valign=top>\n<h2>Resumen Diario por Línea</h2>";
    echo "<table border=1>\n<tr align=center>\n<td><b>fecha<td><b>L-1<td><b>L-2<td><b>L-3<td><b>L-4<td><b>L-5<td><b>L-6<td><b>L-7<td><b>L-8<td><b>L-9<td><b>L-A<td><b>L-B<td><b> TOTAL</td></tr>\n";
    $t1=$t2=$t3=$t4=$t5=$t6=$t7=$t8=$t9=$ta=$tb=$tt=0;
    for ($i=0;$i<pg_numrows($resultado);$i++){
        echo "<tr align=right>\n";
        echo "<td>".pg_result($resultado,$i,fecha)."</td>";
        echo "<td".(pg_result($resultado,$i,l1)==0 ? " bgcolor=yellow>":">").pg_result($resultado,$i,l1)."</td>";
        echo "<td".(pg_result($resultado,$i,l2)==0 ? " bgcolor=yellow>":">").pg_result($resultado,$i,l2)."</td>";
        echo "<td".(pg_result($resultado,$i,l3)==0 ? " bgcolor=yellow>":">").pg_result($resultado,$i,l3)."</td>";
        echo "<td".(pg_result($resultado,$i,l4)==0 ? " bgcolor=yellow>":">").pg_result($resultado,$i,l4)."</td>";
        echo "<td".(pg_result($resultado,$i,l5)==0 ? " bgcolor=yellow>":">").pg_result($resultado,$i,l5)."</td>";
        echo "<td".(pg_result($resultado,$i,l6)==0 ? " bgcolor=yellow>":">").pg_result($resultado,$i,l6)."</td>";
        echo "<td".(pg_result($resultado,$i,l7)==0 ? " bgcolor=yellow>":">").pg_result($resultado,$i,l7)."</td>";
        echo "<td".(pg_result($resultado,$i,l8)==0 ? " bgcolor=yellow>":">").pg_result($resultado,$i,l8)."</td>";
        echo "<td".(pg_result($resultado,$i,l9)==0 ? " bgcolor=yellow>":">").pg_result($resultado,$i,l9)."</td>";
        echo "<td".(pg_result($resultado,$i,la)==0 ? " bgcolor=yellow>":">").pg_result($resultado,$i,la)."</td>";
        echo "<td".(pg_result($resultado,$i,lb)==0 ? " bgcolor=yellow>":">").pg_result($resultado,$i,lb)."</td>";
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
    echo "<td><b>TOTAL</td>";
    echo "<td><b>$t1</td>";
    echo "<td><b>$t2</td>";
    echo "<td><b>$t3</td>";
    echo "<td><b>$t4</td>";
    echo "<td><b>$t5</td>";
    echo "<td><b>$t6</td>";
    echo "<td><b>$t7</td>";
    echo "<td><b>$t8</td>";
    echo "<td><b>$t9</td>";
    echo "<td><b>$ta</td>";
    echo "<td><b>$tb</td>";
    echo "<td><b>$tt</td>";
    echo "</tr></table><br><br><br>\n";
    echo "</td><td align=center valign=top>\n";
    echo "<h2>Resumen Diario por Capturista</h2>\n";
    //select T1.usuario, T2.nombre from reportes T1, plantilla_paso T2 where T1.usuario=T2.usuario and extract(year from T1.fec_mov)=2023 and T1.origen='DU' group by T1.usuario, T2.nombre order by T1.usuario
    //$resultado1=pg_exec($conn_a,"select usuario from reportes where extract(year from fec_mov)=2023 and origen='$origen' group by usuario order by usuario");
    
    // PARA AGREGAR UN NUEVO USUARIO BUSCAR EN LA PLANTILLA

    
    $resultado1=pg_exec($conn_a,"select T1.usuario, T2.nombre from reportes T1, plantilla_paso T2 where  (T1.usuario<>'MOSORIO' AND T1.usuario<>'GIOVANNI' and T1.usuario<>'ABERNAL' and T1.usuario<>'CAROJAS') AND T1.usuario=T2.usuario and extract(year from T1.fec_mov)=2023 and T1.origen='$origen' group by T1.usuario, T2.nombre order by T1.usuario");
    echo "select T1.usuario, T2.nombre from reportes T1, plantilla_paso T2 where  (T1.usuario<>'MOSORIO' AND T1.usuario<>'GIOVANNI' and T1.usuario<>'ABERNAL' and T1.usuario<>'CAROJAS') AND T1.usuario=T2.usuario and extract(year from T1.fec_mov)=2023 and T1.origen='$origen' group by T1.usuario, T2.nombre order by T1.usuario";
    for ($i=0;$i<pg_numrows($resultado1);$i++) $usu[$i]=chop(pg_result($resultado1,$i,usuario));
    for ($i=0;$i<pg_numrows($resultado1);$i++) $nomb[$i]=chop(pg_result($resultado1,$i,nombre));
    for ($i=0;$i<pg_numrows($resultado1);$i++) $usua[$i]="us$i";
    $query="select fecha ";
    for ($i=0;$i<pg_numrows($resultado1);$i++) $query.=",sum(us$i) as us$i";
    $query.=",  sum(tot) as total from
    (
    select fec_mov as fecha, ";

    for ($i=0;$i<pg_numrows($resultado1);$i++) $query.="case when usuario='".$usu[$i]."' then 1 else 0 end as us$i, ";
    $query.=" 1 as tot
    from reportes where extract(year from fec_mov)=2023 and origen='$origen'
    ) as filtro
    group by fecha order by fecha desc
    ";
    //echo $query;
    echo "<table border=1>\n<tr align= center>\n";
    echo "<td><b>N°</td><td><b>fecha</td>";
    for ($i=0;$i<pg_numrows($resultado1);$i++) echo "<td><b>".$nomb[$i]."<br>".$usu[$i]."</td>\n";
    echo "<td><b>Total</td>\n";
    echo "</tr>";

    $resultado2=pg_exec($conn_a,$query);
    for ($i=0;$i<=pg_numrows($resultado1);$i++) $t[$i]=0;
    for ($j=0;$j<pg_numrows($resultado2);$j++){
        $k=$j+1;
        echo "<tr align=right>\n";
        echo "<td align=center>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").$k."</td>\n";
        echo "<td>".(pg_result($resultado2,$j,fecha)==date('Y-m-d') ? "<strong><font color=green>" : "").pg_result($resultado2,$j,fecha)."</td>\n";
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

    echo "<tr align=right>\n";
    echo "<td colspan=2><b>Prom.</td>\n";
    for ($i=0;$i<=pg_numrows($resultado1);$i++)$t[$i]/=pg_numrows($resultado2);
    for ($i=0;$i<=pg_numrows($resultado1);$i++) echo "<td><b>".number_format($t[$i],1)."</td>\n";
    echo "</table><br><br><br>\n";




    echo "<h2>Resumen Diario por Capturista -Actualizaciones de Conductores y Correcciones</h2>\n";
    $resultado1=pg_exec($conn_a,"select usu_correccion from reportes where extract(year from fec_correccion)=2023 and origen='DU' group by usu_correccion order by usu_correccion");
    for ($i=0;$i<pg_numrows($resultado1);$i++) $usu[$i]=chop(pg_result($resultado1,$i,usu_correccion));
    for ($i=0;$i<pg_numrows($resultado1);$i++) $usua[$i]="us$i";
    $query="select fecha ";
    for ($i=0;$i<pg_numrows($resultado1);$i++) $query.=",sum(us$i) as us$i";
    $query.=",  sum(tot) as total from
    (
    select fec_correccion as fecha, ";
    for ($i=0;$i<pg_numrows($resultado1);$i++) $query.="case when usu_correccion='".$usu[$i]."' then 1 else 0 end as us$i, ";
    $query.=" 1 as tot
    from reportes where extract(year from fec_correccion)=2023 and origen='$origen'
    ) as filtro
    group by fecha order by fecha desc
    ";


    echo "<table border=1>\n<tr align= center>\n";
    echo "<td><b>N°</td><td><b>fecha</td>";
    for ($i=0;$i<pg_numrows($resultado1);$i++) echo "<td><b>".$usu[$i]."</td>\n";
    echo "<td><b>Total</td>\n";
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
    echo "<td colspan=2><b>Prom.</td>\n";
    for ($i=0;$i<=pg_numrows($resultado1);$i++)$t[$i]/=pg_numrows($resultado2);
    for ($i=0;$i<=pg_numrows($resultado1);$i++) echo "<td><b>".number_format($t[$i],1)."</td>\n";
    echo "</table><br><br><br>\n";



    }
    include("disconnect.php");
?>
</body>
</html>
