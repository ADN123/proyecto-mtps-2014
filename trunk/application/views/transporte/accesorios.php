                <table cellspacing='0' align='center' class='table_design'>
                    <thead>
                    	<tr>
                            <th>Objeto</th>
                            <th width="100">A bordo</th>
                       	</tr>
                    </thead>
                    <tbody>
                        <?php 
                            $s="";
                            foreach($accesorios as $as) {
                                $s.='<tr title="'.$as->descrip.'" >
                                    <td>'.$as->nombre.'</td>
                                    <td align="center"><input type="checkbox"   name="ac'.$as->id_accesorio.'" id="ac'.$as->id_accesorio.'" class="cheke"  value="'.$as->id_accesorio.'"></td>                        </tr>';
                            }
                            echo $s;
                        ?>       
                    </tbody>
                </table>
                
        