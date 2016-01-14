<?php
/**
 * @param $model
 * @return string
 */
function show_model_error($model)
{
//�õ�model�еĴ�����Ϣ
    $errors = $model->getError();
    $errorMsg = '<ul>';
    if (is_array($errors)) {
        //ѭ�����������Ϣ
        foreach ($errors as $error) {
            $errorMsg .= "<li>{$error}</li>";
        }
    } else {
        $errorMsg .= "<li>{$errors}</li>";
    }
    $errorMsg .= '</ul>';
    return $errorMsg;
}