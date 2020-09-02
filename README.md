# kabucom

## 概要
* auカブドットコム証券 で 個人向けの[取引API](https://kabu.com/company/pressrelease/20200819_1.html)が提供された

* 残念ながら私は、口座がないので申し込み中ではあるが、ウキウキが止まらずAPI仕様が公開されているので、先走って、開発準備を行う。

* 素敵なことに、API仕様は、OpenAPI（Swagger） で定義されているので APIのモックも自分で立ち上げられる。

* これ使って儲けるZ！

## ドキュメント

* github にドキュメントとサンプルスクリプトが置いてある。
  - https://github.com/kabucom/kabusapi/
     - swagger の yaml
       - https://github.com/kabucom/kabusapi/tree/master/reference
     - ドキュメントはここのHTMLにまとまっていた。
       - https://github.com/kabucom/kabusapi/tree/master/ptal

### 構成イメージ
   * APIは、直接カブドットコム証券のAPIを叩くのではなく、 株ステーションのソフトを経由して実行する。
   * つまりソフトの起動が必須な点と、Proxy等を介さない限りは、Windows マシン上で実行するほかなさそう。

### Swagger-UI(仕様書)
* レポジトリの swagger-ui/index.html を参照
* ドキュメントは、直接 kabusapi レポジトリから参照
   - index.html 内の SwaggerUIBundle の url に githubのURLを 入れて直接参照
   - ※[Qiita](https://qiita.com/yousan/items/add59d15eae221d5e1b5)を参考にした。

## Swagger のモックサーバ起動

```
docker run --rm -it -p 4010:4010 stoplight/prism:3 mock -h 0.0.0.0 https://raw.githubusercontent.com/kabucom/kabusapi/master/reference/kabu_STATION_API.yaml
```

### access方法
http://localhost:4010/

### レスポンス確認
```
curl  -H 'Content-Type:application/json' -d '{ "APIPassword": "xxxxxx" }' -X POST http://localhost:4010/token --include
```