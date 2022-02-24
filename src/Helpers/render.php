<?php
function OptionsView($collection, $idKey, $valKey, $default = '', $skip = array())
{
    $str = '';
    if (!empty($collection)) {
        foreach ($collection as $coln) {
            /*print_r($default);*/
            if (in_array($coln->$idKey, $skip)) {
                continue;
            }

            $str .= '<option value="' . $coln->$idKey . '" ';
            if (!is_array($default)) {
                if ($coln->$idKey == $default) {
                    $str .= 'selected="selected"';
                }
            } else {
                if (in_array($coln->$idKey, $default)) {
                    $str .= 'selected="selected"';
                }
            }

            $str .= '>';
            if (is_callable($valKey)) {
                $str .= $valKey($coln);
            } else {
                $str .= $coln->$valKey;
            }

            $str .= '</option>';
        }
    }
    return $str;
}


function isSelected($option, $val)
{
    return $option == $val ? 'selected="selected"' : '';
}

function isMultiSelected($option, $arr)
{
    return in_array($option, $arr) ? 'selected="selected"' : '';
}

function isChecked($option, $val)
{
    return $option == $val ? 'checked="checked"' : '';
}

function isMultiChecked($option, $arr)
{
    return in_array($option, $arr) ? 'checked="checked"' : '';
}


function limit_words($string, $word_limit)
{
    $words = explode(" ", $string);
    return implode(" ", array_splice($words, 0, $word_limit));
}

function word_limit($string, $limit)
{
    $words = explode(" ", $string);
    if (count($words) > $limit) {
        return implode(" ", array_splice($words, 0, $limit));
    } else {
        return $string;
    }

}


function ToJs($data)
{
    echo '<script type="text/javascript">
	    /* <![CDATA[ */';

    foreach ($data as $k => $v) {
        echo 'var ' . $k . '= ' . json_encode($v) . ';';
    }
    echo '/* ]]> */
	    </script>';
}


function Notification()
{
    if (Session::has('success')):
        echo '<div class="alert alert-success">
          		 <button data-dismiss="alert" class="close close-sm" type="button">
          		 <i class="fa fa-times"></i></button>
                 <span class="fa fa-check-circle"></span>
                    ' . Session::get('success') . '
                </div>';

    elseif (Session::has('info')):
        echo '<div class="alert alert-info">
        		 <button data-dismiss="alert" class="close close-sm" type="button">
          		 <i class="fa fa-times"></i></button>
              <span class="fa fa-exclamation-circle"></span>
                    ' . Session::get('info') . '
                </div>';
    elseif (Session::has('error')):
        echo '<div class="alert alert-danger">
          		 <button data-dismiss="alert" class="close close-sm" type="button">
          		 <i class="fa fa-times"></i></button>
                 <span class="fa fa-times-circle"></span>
                    ' . Session::get('error') . '
            </div>';
    endif;

}


function PopupNotification($title, $content)
{
    Session::flash('popupNotification', true);
    Session::flash('popupTitle', $title);
    Session::flash('popupContent', $content);
}


function SuccessTitle($title, $openTag = '<h3 class="text-center text-green bold">', $closeTag = '</h3>')
{
    return $openTag . '<span class="fa fa-check font-20"></span> ' . $title . $closeTag;
}

function ErrorTitle($title, $openTag = '<h3 class="text-center text-red bold">', $closeTag = '</h3>')
{
    return $openTag . '<span class="fa fa-times-circle font-20"></span> ' . $title . $closeTag;
}

function InfoTitle($title, $openTag = '<h3 class="text-center text-blue bold">', $closeTag = '</h3>')
{
    return $openTag . '<span class="fa fa-exclamation-circle font-20"></span> ' . $title . $closeTag;
}

function ReturnNotification($notificationAr, $flashIt = true)
{
    if (@$notificationAr['success']):
        if ($flashIt) {
            Session::flash('success', $notificationAr['success']);
        }
        return '<div class="alert alert-success">
          		 <button data-dismiss="alert" class="close close-sm" type="button">
          		 <i class="fa fa-times"></i></button>
                 <span class="fa fa-check"></span>
                    ' . $notificationAr['success'] . '
                </div>';

    elseif (@$notificationAr['info']):
        if ($flashIt) {
            Session::flash('info', $notificationAr['info']);
        }
        return '<div class="alert alert-info">
        		 <button data-dismiss="alert" class="close close-sm" type="button">
          		 <i class="fa fa-times"></i></button>
              <span class="fa fa-exclamation-circle"></span>
                    ' . $notificationAr['info'] . '
                </div>';
    elseif (@$notificationAr['error']):
        if ($flashIt) {
            Session::flash('error', $notificationAr['error']);
        }
        return '<div class="alert alert-danger">
          		 <button data-dismiss="alert" class="close close-sm" type="button">
          		 <i class="fa fa-times"></i></button>
                 <span class="fa fa-times-circle"></span>
                    ' . $notificationAr['error'] . '
            </div>';
    endif;

}


function ReturnQuickNotification($notificationAr, $flashIt = true)
{
    if (@$notificationAr['success']):
        if ($flashIt) {
            Session::flash('success', $notificationAr['success']);
        }
        return array(
            'title' => 'Success',
            'text' => $notificationAr['success'],
            'type' => 'success'
        );
    elseif (@$notificationAr['info']):
        if ($flashIt) {
            Session::flash('info', $notificationAr['info']);
        }
        return array(
            'title' => 'Information ',
            'text' => $notificationAr['info'],
            'type' => 'info'
        );
    elseif (@$notificationAr['error']):
        if ($flashIt) {
            Session::flash('error', $notificationAr['error']);
        }
        return array(
            'title' => 'Oops!',
            'text' => $notificationAr['error'],
            'type' => 'danger'
        );
    endif;
}

function ValidationNotification($errors)
{
    if ($errors->count() > 0):

        foreach ($errors->all(
            '<div class="alert alert-danger">
            		 <button data-dismiss="alert" class="close close-sm" type="button">
          		 <i class="fa fa-times"></i></button>
                             <strong>Error!</strong>
                             :message
                         </div>'
        ) as $message) {
            echo $message;
        }

    endif;
}


function ReturnValidationNotification($errors)
{
    if ($errors->count() > 0):
        $msg = '';
        foreach ($errors->all(
            '<div class="alert alert-danger">
            		 <button data-dismiss="alert" class="close close-sm" type="button">
          		 <i class="fa fa-times"></i></button>
                             <strong>Error!</strong>
                             :message
                         </div>'
        ) as $message) {
            $msg .= $message;
        }
        return $msg;

    endif;
}
