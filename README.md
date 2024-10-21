# 自分用
## 数年前に公開終了したWordPressのメールフォームプラグイン「Trust Form」。

本体アップデート（というよりも`jQuery`のメソッド廃止）の影響でUIに不具合が発生し、いよいよ使えなくなる？

否、できれば使い続けたいので、思い切ってデバッグしてみました。

[メモ](https://misskey.io/notes/9z5c8vu1awtm0ffd)

## 他にも営業メールを弾くためにNGワード機能とか追加。
- 管理画面でNGワードやアラートメッセージを編集することができない
   - `php`ファイルを直接編集して追加
- 直接POSTしてくる自動ツール等は弾けない気がする

## 中の人はほぼ素人です。
- プラグインは、バージョン1.5.7を書き換えています。
   - 10年近く前、外部のWeb制作会社から移管したWordPressサイトにインストールされていた版をそのまま使用しています。
   - WordPressのPlugin Directoryを確認したところ、バージョン2.0.1（at 2016）が最新版のようです。
- プラグイン構成ファイルすべてではなく、編集したファイルのみアップしています。
- 現在の`jQuery`・`php`・`WordPress`で非推奨とされている箇所などは（まだ必要に駆られてないので）触ってないです。

プラグイン本体に『GNU General Public License』と記載されているので大丈夫だと思いますが、もし然るべき方からお叱りを受けたら、このリポジトリは`private`に変更するなど対応いたします。
