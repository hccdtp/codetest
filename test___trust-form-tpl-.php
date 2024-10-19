<?php
function trust_form_show_input() {
	global $trust_form;
	$col_name = $trust_form->get_col_name();
	$validate = $trust_form->get_validate();
	$config = $trust_form->get_config();
	$attention = $trust_form->get_attention();

	$nonce = wp_nonce_field('trust_form','trust_form_input_nonce_field');

	$html = <<<EOT
<div id="trust-form" class="contact-form contact-form-input" >
<p id="message-container-input">{$trust_form->get_input_top()}</p>
<form action="?confirm#trust-form" method="post" >
<table>
<tbody>
EOT;

	foreach ( $col_name as $key => $name ) {
		// 以前の入力内容を保持
		$value = isset($_POST[$key]) ? esc_html($_POST[$key]) : '';
		$html .= '<tr><th scope="row"><div class="subject"><span class="content">'.$name.'</span>'.(isset($validate[$key]['required']) && $validate[$key]['required'] == 'true' ? '<span class="require">'.$config['require'].'</span>' : '' ).'</div><div class="submessage">'.$attention[$key].'</div></th><td><div>'.$trust_form->get_element( $key, $value ).'</div>'; // ここを修正

		$err_msg = $trust_form->get_err_msg($key);
		if ( isset($err_msg) && is_array($err_msg) ) {
			$html .= '<div class="error">';
			foreach ( $err_msg as $msg ) {
				$html .= $msg.'<br />';
			}
			$html .= '</div>';
		}
		$html .= '</td></tr>';
	}
	$html .= <<<EOT
</tbody>
</table>
{$nonce}
EOT;
	$html = apply_filters( 'tr_input_footer', $html );
	$html .= <<<EOT
<p id="confirm-button" class="submit-container">{$trust_form->get_form('input_bottom')}</p>
</form>
</div>
EOT;

	return $html;
}

function trust_form_show_confirm() {
	global $trust_form;
	$col_name = $trust_form->get_col_name();
	$validates = $trust_form->get_validate();
	$nonce = wp_nonce_field('trust_form','trust_form_confirm_nonce_field');

	// NGワードのリスト
	$ng_words = ['ビジネスプロフィール', 'オンラインアウトソーシング', '配信停止', 'コンサルタント', 'コンサルティング', '運用代行', 'ランディングページ', 'プロモーション', 'トライアル', '自動化ツール', 'アポ取得', 'アポ獲得', '出演', '中国市場', 'オンラインMTG', 'オンラインミーティング', '初期費用', '完全成果報酬型']; // ここにNGワードを追加

	// NGワードチェック
	$has_ng_word = false;
	foreach ($_POST as $value) {
		foreach ($ng_words as $ng_word) {
			if (stripos($value, $ng_word) !== false) {
				$has_ng_word = true;
				break 2; // NGワードが見つかったらループを抜ける
			}
		}
	}

	// NGワードがある場合の処理
	if ($has_ng_word) {
		// エラーメッセージを表示
		return '<div class="error">ご入力内容に不適切な言葉が含まれています。内容を確認してください。</div>';
	}

	$html = <<<EOT
<div id="trust-form" class="contact-form contact-form-confirm" >
<p id="message-container-confirm">{$trust_form->get_form('confirm_top')}</p>
<form action="?thanks#trust-form" method="post" >
<table>
<tbody>
EOT;

	foreach ( $col_name as $key => $name ) {
		foreach ( $validates as $validate ) {
			if ( array_key_exists('e_mail_confirm', $validate) && in_array( $name, $validate ) )
				continue 2;
		}

		$html .= '<tr><th><div class="subject">'.$name.'</div></th><td><div>'.$trust_form->get_input_data($key).'</div>'; // ここを修正
		$html .= '</td></tr>';
	}
	$html .= <<<EOT
</tbody>
</table>
{$nonce}
EOT;
	$html = apply_filters( 'tr_confirm_footer', $html );
	$html .= <<<EOT
<p id="confirm-button" class="submit-container">{$trust_form->get_form('confirm_bottom')}</p>
</form>
</div>
EOT;
	return $html;
}

function trust_form_show_finish() {
	global $trust_form;

	$html = <<<EOT
<div id="trust-form" class="contact-form contact-form-finish" >
<p id="message-container-confirm">{$trust_form->get_form('finish')}</p>
</div>
EOT;
	return $html;
}
?>
