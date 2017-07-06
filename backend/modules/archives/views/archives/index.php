<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdminSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => '文档管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$this->registerJsFile('@web/js/bootstrap.min.js', ['depends'=>[\backend\assets\AppAsset::className()],'position'=>$this::POS_END]);

?>

    <div class="col-lg-12">
        <div class="box">            
            <div class="box-header" data-original-title="<?= Html::encode($this->title) ?>">
                <h2>
                    <i class="fa fa-user"></i>
                    <span class="break"></span>
                    <?= Html::encode($this->title) ?>
                </h2>
                <div class="box-icon">
                    <a href="#" class="btn-setting"><i class="fa fa-wrench"></i></a>
                    <a href="#" class="btn-minimize"><i class="fa fa-chevron-up"></i></a>
                    <a href="#" class="btn-close"><i class="fa fa-times"></i></a>
                </div>
            </div>

            <div class="box-content text-center">
                <div class="row">
                    <div class="col-lg-12">
                    <p class="text-left">
                        <?php
                        echo \yii\bootstrap\Html::a('添加文档', ['add'], ['class' => 'btn btn-primary','alt'=>'添加栏目']) . "&nbsp;&nbsp;";
                        echo \yii\bootstrap\Html::a('编辑', 'javascript:void(0)', ['onclick' => "commonDataOperate('get','','" . yii\helpers\Url::to(['update']) . "','','selection[]','input','checked',true)", 'class' => 'btn btn-primary', 'alt' => '编辑']) . "&nbsp;&nbsp;";
                        echo \yii\bootstrap\Html::a('审核', 'javascript:void(0)', ['onclick' => "commonDataOperate('post','','" . yii\helpers\Url::to(['audit']) . "','确定要审核吗？','selection[]','input','checked',false,false,false,true)", 'class' => 'btn btn-primary', 'alt' => '审核']) . "&nbsp;&nbsp;";
                        echo \yii\bootstrap\Html::a('屏蔽', 'javascript:void(0)', ['onclick' => "commonDataOperate('post','','" . yii\helpers\Url::to(['disable']) . "','确定要屏蔽吗？','selection[]','input','checked',false,false,false,true)", 'class' => 'btn btn-primary', 'alt' => '屏蔽']) . "&nbsp;&nbsp;";
                        echo \yii\bootstrap\Html::a('批量删除', 'javascript:void(0)', ['onclick' => "commonDataOperate('post','".Yii::$app->request->getCsrfToken()."','" . yii\helpers\Url::to(['delete']) . "','确定要删除所选么？','selection[]','input','checked',false,false,false,true)", 'class' => 'btn btn-primary', 'alt' => '批量删除']) . "&nbsp;&nbsp;";
                        
                        ?>
                    </p></div>
                </div>
                    <?php 
                    //echo $this->render('/cooperation/_search', ['model' => $searchModel]);
                    //Pjax::begin(['id' => 'cooperation','timeout'=>3000]);
                    echo GridView::widget([
                        'dataProvider' => $list,
                        'layout' => "{items}\n{pager}",
//                        'options'=>[],
//                        'pager'=>[ 
//                            //'options'=>['class'=>'hidden'],
//                            //关闭分页 
//                            'firstPageLabel'=>"首页", 
//                            'prevPageLabel'=>'上一页', 
//                            'nextPageLabel'=>'下一页', 
//                            'lastPageLabel'=>'尾页', 
//                        ],
//                        'tableOptions' => [
//                            'class' => 'table table-striped table-bordered bootstrap-datatable datatable dataTable',
//                            'id' => 'DataTables_Table_0',
//                            'aria-describedby' => 'DataTables_Table_0_info',
//                        ],
//                        'headerRowOptions' => [
//                            'role' => 'row',
//                            'class'=>'text-center',
//                        ],
//                        'rowOptions'=>[
//                            
//                        ],
                        'columns' => [
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'headerOptions' => ['class'=>'text-center'],
                            ],
                            [
                                'attribute'=>'id',
                                //'label'=>'ID',
                                //'formate'=>'int',
                                //'content'=>function($model){return $model->id;}
                                'headerOptions'=>['class'=>'text-center']
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => '操作',
                                'template' => '{view}{update}{audit}{disable}{delete}',
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => [],
                                'buttons' => [
                                    'view'=>function($url,$model,$key){
                                        return Html::a('查看', $url, [
                                            'title' => '查看',
                                            'data-method' => 'get',
                                            'data-pjax' => '0',
                                            'class'=>'btn-xs btn-info',
                                        ])."&nbsp;";
                                    },
                                    'update'=>function($url,$model,$key){
                                        return Html::a('编辑', $url, [
                                            'title' => '编辑',
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                            'class'=>'btn-xs btn-success'
                                        ])."&nbsp;";
                                    },
                                    'audit'=>function($url,$model,$key){
                                        return Html::a('审核', $url, [
                                            'title' => '审核',
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                            'data-confirm'=>'确定审核吗',
                                            'class'=>'btn-xs btn-info',
                                        ])."&nbsp;";
                                    },
                                    'disable'=>function($url,$model,$key){
                                        return Html::a('屏蔽', $url, [
                                            'title' => '屏蔽',
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                            'data-confirm'=>'确定屏蔽吗',
                                            'class'=>'btn-xs btn-success'
                                        ])."&nbsp;";
                                    },
                                    'delete'=>function($url,$model,$key){
                                        return Html::a('删除', \yii\helpers\Url::to(['delete','id'=>$model->id]), [
                                            'title' => '删除',
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                            'data-confirm'=>'确定删除吗',
                                            'class'=>'btn-xs btn-danger'
                                        ])."&nbsp;";
                                    },
                                ],
                            ],
                            //['attribute'=>'','label'=>'当前时间','content'=>function($model){return ;}],
                            [
                                'attribute'=>'title',
                                //'label'=>'ID',
                                //'formate'=>'int',
                                //'content'=>function($model){return $model->id;}
                                'headerOptions'=>['class'=>'text-center']
                            ],
                            [
                                'attribute'=>'type_id',
                                //'label'=>'ID',
                                //'formate'=>'int',
                                'content'=>function($model){return backend\logic\ArchivesLogic::getInstance()->loadModel('ArchivesTypeModel')->getModel()->find()->select('type_name')->where(['id'=>$model->type_id])->scalar();},
                                'headerOptions'=>['class'=>'text-center']
                            ],
                            [
                                'attribute'=>'status',
                                'label'=>'文档状态',
                                //'formate'=>'int',
                                'content'=>function($model){return Yii::$app->params['extend_params']['doc_status'][$model->status];},
                                'headerOptions'=>['class'=>'text-center']
                            ],
                            [
                                'attribute'=>'is_disable',
                                'label'=>'屏蔽状态',
                                //'formate'=>'int',
                                'content'=>function($model){return Yii::$app->params['extend_params']['doc_disable_status'][$model->status];},
                                'headerOptions'=>['class'=>'text-center']
                            ],
                            [
                                'attribute'=>'user_id',
                                'label'=>'发布人',
                                //'formate'=>'int',
                                'content'=>function($model){return backend\logic\UserLogic::getInstance()->loadModel('User')->getModel()->find()->select('username')->where(['id'=>$model->user_id])->scalar();},
                                'headerOptions'=>['class'=>'text-center']
                            ],
                            [
                                'attribute'=>'created_at',
                                //'label'=>'ID',
                                //'formate'=>'int',
                                'content'=>function($model){return date("Y-m-d H:i",$model->created_at);},
                                'headerOptions'=>['class'=>'text-center']
                            ],                            
                        ],
                    ]);
                    ?>
<?php 
//Pjax::end(); 
?>
            </div>
        </div>
    </div>