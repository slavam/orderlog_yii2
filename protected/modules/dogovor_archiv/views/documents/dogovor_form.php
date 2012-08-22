<div class="form">
<?php
echo $form->renderBegin();
?> 
    <div class="block_wrapper">
    <table width="900">
          <thead>
            <tr>
                <th>Классификация документа</th>
                <th>Нумерация и сроки</th>
                <th>Финансовые признаки</th>
<!--                <th>Общие сведения</th> -->
            </tr>
          </thead>      
    <tr>
        <td>
             <table>

                <tr>
                    <td>
                        <table>
<!--                            <tr>
                                <td colspan="2"><b><?//echo $model->templ_description;?></b></td>
                            </tr>-->
                            <tr>
                                <td width="154"><b><?echo $model->templ_description; ?></b></td>
                                <td><?echo $form['status'];?></td>
                            </tr>
                        </table>

                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                               <td> <?echo $form['dog_kind'];?></td>
                                <td><?echo $form['author_login'];?></td>
                            </tr>                         
                        </table>
                        </td>
                </tr>
                <tr>
                    <td><?echo $form['dog_type'];?></td>
                </tr>
            </table>
       </td>
       <td>
           <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td><? echo $form['inside_number'];?></td>
                            <td><?echo $form['dog_fact_date'];?></td>
                        </tr>
                        <tr>
                            <td><? echo $form['dog_number'];?></td>
                            <td><?echo  $form['dog_date'];?></td>
                        </tr>
                    
                    </table>
                    
                </td>
            </tr>
            <tr>
               <td><?echo $form['dog_period'];?></td>
            </tr>
           </table> 
       </td>
       <td>
                <table>
                        
                       
                        <tr>
                            <td><?echo $form['tarif_type'];?></td>
                        </tr>
                        <tr>
                            <td><?echo $form['tarif'];?></td>
                        </tr>
                         <tr>
                            <td><?echo $form['reward_percent'];?></td>
                        </tr>
                </table> 
                            <?echo $form['reestr'];?>
       </td>
        
</table>
</div>    
    
<div class="block_wrapper">    
    <table width="900">
        <thead>
            <tr>
                <th>Сведения контрагента</th>
            </tr>
        </thead>
        
        <tr>
            <td>
            <table>
                <tr>
                    <td><?echo $form['provider'];?></td>
                    <td><?echo $form['okpo'];?></td>
                </tr>
            </table>
            </td>
        </tr>
        <tr>
            <td><?echo $form['provider_contact'];?></td>
        </tr>
         
        <tr>
            <td>
                <table>
                    <tr>
                        <td><?echo $form['recipient'];?></td>
                        <td><?echo $form['pay_system'];?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><?echo $form['subject'];?></td>
        </tr>
        
        <tr>
            <td><?echo $form['note'];?></td>
        </tr>
        <tr>
            <td><?echo $form['delegation'];?></td>
        </tr>
    </table>
</div>    
<?php 
foreach($form->getButtons() as $element)
    echo $element->render();
echo $form->renderEnd();

$this->widget('application.components.DocAttachmentBlock',array('model'=>$model,'title'=>'Список прикрепленных файлов'));
?>
</div>