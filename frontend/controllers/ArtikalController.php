<?php

namespace frontend\controllers;

use app\models\Narudzbina;
use Yii;
use frontend\models\Artikal;
use frontend\models\ArtikalSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use frontend\models\KategorijaArtikal;
use frontend\models\Kategorija;
use yii\helpers\ArrayHelper;
use common\models\User;
use app\models\Adresa;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\ArtikalNarudzbina;
/**
 * ArtikalController implements the CRUD actions for Artikal model.
 */
class ArtikalController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Artikal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArtikalSearch();
        $artikli = $searchModel->getAllArtikal();
        $dataProvider = $searchModel->search($artikli, Yii::$app->request->queryParams);
        if (Yii::$app->request->isAjax){
            return $this->renderAjax('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single Artikal model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $session = Yii::$app->session;
        $session->open();
        $model = $this->findModel($id);
        $kategorija = new Kategorija();
        $kategorije = $kategorija->getKategorijaByArtikal($id);
        return $this->render('view', [
            'model' => $model,
            'kategorije' => $kategorije
        ]);
    }

    /**
     * Creates a new Artikal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-artikal')) {
            $model = new Artikal();
            $model->scenario = 'create';
            $kategorija = new Kategorija();
            if ($model->load(Yii::$app->request->post())) {
                $this->uploadSlika($model);
                $kategorijaArtikal = new KategorijaArtikal();
                $nazivKategorije = Yii::$app->request->post('Kategorija')['naziv'];
                //$model->save();
                /*if(!$model->save()){
                    $errors = $model->errors;

                }*/
                $model->save();
                $kategorijaArtikal->upisiKategorijuArtikla($model->id, $nazivKategorije);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'kategorija' => $kategorija,
                ]);
            }
        } else throw new ForbiddenHttpException;
    }

    /**
     * Updates an existing Artikal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('update-artikal')) {
            $model = $this->findModel($id);
            $kategorija = new Kategorija();
            $kategorijaArtikal = new KategorijaArtikal();
            $postojeceKategorije = $kategorija->getKategorijaByArtikal($id);
            if ($model->load(Yii::$app->request->post())) {
                $this->uploadSlika($model);
                if (!empty(Yii::$app->request->post('Kategorija')['naziv'])) {
                    $nazivKategorije = Yii::$app->request->post('Kategorija')['naziv'];
                    $kategorijaArtikal->upisiKategorijuArtikla($model->id, $nazivKategorije);
                }
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'kategorija' => $kategorija,
                    'postojeceKategorije' => $postojeceKategorije,
                ]);
            }
        } else throw new ForbiddenHttpException;
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Deletes an existing Artikal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-artikal')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else throw new ForbiddenHttpException;
    }

    /**
     * Finds the Artikal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Artikal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Artikal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //moje metode###################################################################################

    public function getNazivKategorije($nazivKategorije)
    {

        $searchModel = new ArtikalSearch();
            $artikliPoKategoriji = $searchModel->getArtikalByKategorijaNaziv($nazivKategorije);
            $dataProvider = $searchModel->search($artikliPoKategoriji, Yii::$app->request->queryParams);
        return $this->render('kategorijePosebno', [
                'nazivKategorije' => $nazivKategorije,
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }
    public function actionKozmetika()
    {
        return $this->getNazivKategorije('kozmetika');
    }

    public function actionHigijena()
    {
        return $this->getNazivKategorije('higijena');
    }

    public function actionKucnaHemija()
    {
        return $this->getNazivKategorije('kucna hemija');
    }

    public function uploadSlika($model)
    {
        $upload_slika = UploadedFile::getInstance($model, 'upload_slika');
        if (!empty($upload_slika)) {
            $imeSlike = $upload_slika->name;
            $model->slika = $imeSlike;
        }
        if ($model->validate() && $model->save()) {
            if (!empty($upload_slika)) {
                $upload_slika->saveAs(Yii::getAlias('@slikaPath') . '/' . $imeSlike);
            }
        }
    }

    public function actionObrisi($id)
    {
        if (Yii::$app->user->can('obrisi-kategoriju')) {
            $kategorijaArtikal = new KategorijaArtikal();
            if ($kategorijaArtikal->ArtikalImaBarJednuKategoriju($id) == false) {
                //$model = $this->findModel($id);
                $kategorijaArtikal->obrisiKategorijuArtikla($_GET['id'], $_GET['idPostojeceKategorije']);
                echo '<script>history.go(-1);</script>';
                Yii::$app->session->setFlash('success','Kategorija uspesno obrisana!');
                //return $this->redirect(['view', 'id' => $model->id]);
            } else {//throw new ForbiddenHttpException('Artikal mora da pripada barem jednoj kategoriji!');
                echo '<script>alert("Artikal mora da pripada barem jednoj kategoriji!");
                    history.go(-1);
                </script>';
            }
        }
    }

    public function actionKorpa($id)
    {
        $session = Yii::$app->session;
        $session->open();
        $model = $this->findModel($id);
        if (isset($_SESSION['shopping_cart'])) {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case "ukloni":
                        foreach ($_SESSION['shopping_cart'] as $keys => $values) {
                            if ($values['id'] == $model->id) {
                                unset($_SESSION['shopping_cart'][$keys]);
                                if (empty($_SESSION['shopping_cart'])) {
                                    //$this->redirect('/artikal');
                                    echo '<script>alert("Korpa je prazna!")</script>';
                                    echo '<script>window.location.assign("http://online-shop.org/artikal");</script>';
                                } else
                                    echo '<script>alert("Artikal je uklonjen iz korpe!")</script>';
                            }
                        }
                        break;
                    case "porudzbina":
                        // echo '<script>alert("Eve vi korpa!")</script>';
                        break;
                }
            } else {
                $idSession = array_column($_SESSION['shopping_cart'], 'id');
                $niz = ArrayHelper::toArray($model);
                if (!in_array($niz['id'], $idSession)) {
                    if (empty ($_SESSION['shopping_cart'])) {
                        $_SESSION['shopping_cart'][0] = $niz;
                    } else {
                        $_SESSION['shopping_cart'][max(array_keys($_SESSION['shopping_cart'])) + 1] = $niz;
                    }
                } else {
                    echo '<script>alert("Artikal je vec dodat u korpu!")</script>';
                }
            }
        } else {
            $niz = ArrayHelper::toArray($model);
            $_SESSION['shopping_cart'][0] = $niz;
        }
        return $this->render('korpa');
    }
    public function actionPoruci()
    {
        //pre posta

        $session = Yii::$app->session;
        $session->open();
        $obj1 = new User();
        $obj2 = new Adresa();
       if (Yii::$app->request->isAjax && $obj1->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($obj1,$obj2);
        }
        if(!Yii::$app->user->isGuest) {
            $idUser = Yii::$app->user->id;
            $modelUser = $obj1->findIdentity($idUser);
            if (!empty($obj2->getAdresaByUserId($idUser))) {
                $modelAdresa = $obj2->getAdresaByUserId($idUser);
            } elseif(isset($session['adresaPoslePosta'])) {
                $modelAdresa = $session['adresaPoslePosta'];
            }else {
                $modelAdresa = $obj2;

            }
        } else {
            $modelUser = $obj1;
            $modelAdresa = $obj2;
        }

        //post

        if ($modelUser->load(Yii::$app->request->post()) && $modelAdresa->load(Yii::$app->request->post())
        && $modelUser->validate() && $modelAdresa->validate()) {
            $request = Yii::$app->request;
            $session = Yii::$app->session;
            $session->open();
            $artikal = $session->get('shopping_cart');
            $usercina = $request->post('User');
            $adrescina = $request->post('Adresa');
            $korisnik = [
                'ime' => $usercina['username'],
                'email' => $usercina['email'],
                'ulica' => $adrescina['ulica'],
                'ulicni_broj' => $adrescina['ulicni_broj'],
                'grad' => $adrescina['grad'],
                'postanski_broj' => $adrescina['postanski_broj'],
                'zemlja' => $adrescina['zemlja'],
            ];
            $narudzbina = new Narudzbina();
            $narudzbinaId = $narudzbina->getAllNarudzbinaId();
            foreach ($narudzbinaId as $key => $value) {
                $nizId[] = $value['id'];
            }
            $noviId = max($nizId) + 1;

            //vrednosti posle posta u sesiju

            $session->set('userPoslePosta',$modelUser);
            $session->set('adresaPoslePosta',$modelAdresa);

            //

            Yii::$app->session->setFlash('info', '<h2><b>'.ucfirst($modelUser->username).'</b>, uspesno ste napravili narudzbenicu!</h2>');
            return $this->render('narudzbenica', [
                'artikal' => $artikal,
                'ukupno' => $session->get('ukupno'),
                'korisnik' => $korisnik,
                'noviId' => $noviId
            ]);
        } elseif(Yii::$app->request->isAjax) {
                return $this->renderAjax('porudzbina', [
                    'modelUser' => $modelUser,
                    'modelAdresa' => $modelAdresa
                ]);
            }elseif (isset($session['shopping_cart'])){
                return $this->render('porudzbina', [
                'modelUser' => $modelUser,
                'modelAdresa' => $modelAdresa
            ]);
        }else {
            Yii::$app->session->setFlash('danger','Ne postoji ni jedan artikal u korpi!');
            $this->redirect('/artikal');
        }

    }

    public function actionPotvrdiPorudzbinu()
    {
        $session = Yii::$app->session;
        $session->open();

        $user = new User;
        $adresa = new Adresa;
        $userPoslePosta = $session->get('userPoslePosta');
        $adresaPoslePosta = $session->get('adresaPoslePosta');

        $username = $userPoslePosta->username;
        $postojiUser = $user->getUserByUsername($username);
        $postojiAdresa = $adresa->postojiAdresa($adresaPoslePosta);

        //user se prijavio ili je bio prijavljen, a nema adresu da potvrdi porudzbinu

        if(empty($postojiAdresa)) {
            $userId = $postojiUser->id;
            $adresaUseraPrePosta = $adresa->getAdresaByUserId($userId);
            if(!isset($adresaUseraPrePosta)) {
                //$adresa->dodajNovuAdresu($adresaPoslePosta);
                $adresaPoslePosta->save();
                //$idPoslednjeAdrese = $adresa->idPoslednjeAdreseBaza();
                //$postojiUser->adresa_id = $idPoslednjeAdrese;
                $postojiUser->adresa_id = $adresaPoslePosta->id;
                $postojiUser->save();
            }else {
                $adresaPoslePosta->save();
            }

        //user i adresa nisu prazni i postoje u bazi

    } else {
            $userId = $postojiUser->id;
            $adresaUseraPrePosta = $adresa->getAdresaByUserId($userId);
            if ($adresaUseraPrePosta->id !== $postojiAdresa->id) {
                $postojiUser->adresa_id = $postojiAdresa->id;
                $postojiUser->save();
            }
        }
        $narudzbina = new Narudzbina();
        $narudzbina->user_id = Yii::$app->user->id;
        $narudzbina->save();
        if ((isset($session['shopping_cart']))) {
            foreach ($session->get('shopping_cart') as $key => $value) {
                $obj = new ArtikalNarudzbina();
                $obj->narudzbina_id = $narudzbina->id;
                $obj->artikal_id = $value['id'];
                $obj->save();
            }
            unset($session['shopping_cart']);
            echo '<script>window.alert("Uspesno ste izvrsili porudzbinu!")</script>';
            echo '<script>window.location.assign("http://online-shop.org/artikal");</script>';
            //return $this->goHome();
        } else {
            echo '<script>window.alert("Ne postoji ni jedan artikal u korpi!")</script>';
            //$this->redirect('/artikal');
            echo '<script>window.location.assign("http://online-shop.org/artikal");</script>';
        }
    }
    public function actionPonistiPorudzbinu()
    {
        $model = new Artikal();
        $userId = Yii::$app->user->id;
        $poslednjaPorudzbina = $model->getArtikalByPorudzbina($userId);
        if(Yii::$app->request->post()){}
        return $this->render('ponistiPorudzbinu',[
            'poslednjaPorudzbina'=>$poslednjaPorudzbina
        ]);
    }
}