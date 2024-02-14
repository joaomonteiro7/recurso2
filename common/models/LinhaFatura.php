<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linha_fatura".
 *
 * @property int $id
 * @property int|null $produto_id
 * @property int|null $fatura_id
 * @property float|null $quantity
 */
class LinhaFatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linha_fatura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produto_id', 'fatura_id'], 'integer'],
            [['quantity'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'produto_id' => 'Produto ID',
            'fatura_id' => 'Fatura ID',
            'quantity' => 'Quantity',
        ];
    }
}
