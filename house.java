package com.webapp.android;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.net.Uri;
import android.os.Environment;
import android.os.Parcelable;
import android.provider.MediaStore;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.webkit.ConsoleMessage;
import android.webkit.ValueCallback;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.webkit.WebSettings;
import android.webkit.WebViewClient;
import android.widget.ProgressBar;
import android.widget.Toast;

import java.io.File;

public class SplashActivity extends AppCompatActivity {

    //String urlLien = "http://192.168.49.252/Web_App_Houses/index.html";
    String urlLien = "https://nossavoirs.blogspot.com";
    private WebView webView;
    final Activity activity = this;
    public Uri imageUri;

    private static final int FILECHOOSER_RESULTCODE = 2888;
    private ValueCallback<Uri> mUploadMessage;
    private Uri mCapturedImageURI = null;

    // Instanciation de l'activite
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash);

        //Reception du WebView
        webView = (WebView) findViewById(R.id.mWeb);

        //Activationdu javaCript dans WebView
        webView.getSettings().setJavaScriptEnabled(true);

        //Autres options du WebView
        webView.getSettings().setLoadWithOverviewMode(true);
        webView.getSettings().setUseWideViewPort(true);

        //Autres parametres du WebView
        webView.setScrollBarStyle(WebView.SCROLLBARS_OUTSIDE_OVERLAY);
        webView.setScrollbarFadingEnabled(false);
        webView.getSettings().setBuiltInZoomControls(true);
        webView.getSettings().setPluginState(WebSettings.PluginState.ON);
        webView.getSettings().setAllowFileAccess(true);
        webView.getSettings().setSupportZoom(true);

        //Afficher le site dans WebView
        webView.loadUrl(urlLien);

        //Definition du management Classe
        startWebWiew();

    }// Fin de onCreate

    //Creation de la classe startWebView
    public void startWebWiew(){

        webView.setWebViewClient(new WebViewClient(){
            ProgressDialog progressDialog;
            //Si vous n'utilisez pas cette methode le lien s;ouvrira dans le navigateur etnon dans le webview
            public boolean shouldOverrideUrlLoading(WebView view, String url){
                //Check if Url contains ExternalLink String in url
                //then open url in web browser
                //else all webview links will open in webview browser
                if (url.contains("google")){
                    //Could be cleverer and use a regeX
                    //Open links in web browser
                    view.getContext().startActivity(
                            new Intent(Intent.ACTION_VIEW, Uri.parse(url))
                    );

                    //Ici nous pouvons ouvrir une nouvelle activite
                    return true;
                }else{
                    //rester dans le webView et ouvrir l'url
                    view.loadUrl(url);
                    return true;
                }
            }

            //Afficher le chargement dans le chargement d'url
            public void onLoadRessource (WebView view, String url){
                //if url contains string androidexemple
                //then show progress Dialog
                if (progressDialog == null  && url.contains("androidexample")){
                    // in start case YourActivity.this
                    progressDialog = new ProgressDialog(SplashActivity.this);
                    progressDialog.setMessage("Chargement...");
                    progressDialog.show();
                }
            }

            //Called when all page ressources loaded
            public void onPageFinished(WebView view, String url){
                try {
                    // Close progressDialog
                    if (progressDialog.isShowing()){
                        progressDialog.dismiss();
                        progressDialog = null;

                    }
                }catch (Exception exception){
                    exception.printStackTrace();
                }
            }
        });

        //You can create external class extends whith WebChromeClient
        //Taking WebviewClient as inner class
        //We Will define openFileChooser for select file from camera or sdcard

        webView.setWebChromeClient(new WebChromeClient(){
            // openFileChooser for Android 3.0+
            public void openFileChooser(ValueCallback<Uri> uploadMsg, String acceptType){
                //Update Message
                mUploadMessage = uploadMsg;
                try {
                    //Create AndroidExampleFolder at sdcard

                    File imageStorageDir = new File(
                            Environment.getExternalStoragePublicDirectory(
                                    Environment.DIRECTORY_PICTURES
                            ), "AndroidExampleFolder"
                    );
                    if (!imageStorageDir.exists()){
                        //Ceate AndroidExampleFolder at sdcard
                        imageStorageDir.mkdirs();
                    }

                    //Create camera captured image
                    File file = new File(
                            imageStorageDir + File.separator + "IMG_"
                            + String.valueOf(System.currentTimeMillis())
                            + ".jpg"
                    );

                    //Camera capture image intent
                    final Intent captureIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
                    captureIntent.putExtra(MediaStore.EXTRA_OUTPUT, mCapturedImageURI);

                    Intent i = new Intent(Intent.ACTION_GET_CONTENT);
                    i.addCategory(Intent.CATEGORY_OPENABLE);
                    i.setType("inage/*");

                    //Create file chooser intent
                    Intent chooserIntent = Intent.createChooser(i, "Image Chooser");

                    //Set Camera intent to file chooser
                    chooserIntent.putExtra(Intent.EXTRA_INITIAL_INTENTS,
                            new Parcelable[]{captureIntent});

                    //On select Image call onActivityResult method of activity
                    startActivityForResult(chooserIntent, FILECHOOSER_RESULTCODE);

                }catch (Exception e){
                    Toast.makeText(getApplicationContext(), "Exception : "+e, Toast.LENGTH_SHORT).show();
                }
            }

            // openFileChooser for Android < 3.0
            public void openFileChooser(ValueCallback<Uri> uploadMsg){
                openFileChooser(uploadMsg, "");
            }

            //openFileChooser for other Android versions
            public void openFileChooser(ValueCallback<Uri> uploadMsg, String acceptType, String capture){
                openFileChooser(uploadMsg, acceptType);
            }

            //ZThe webPage has 2 fileChoosers and will send a
            //Console message informing what action to performm
            // taking a photo ar updating the file
            public  boolean onConsoleMessage(ConsoleMessage cm){
                onConsoleMessage(cm.message(),cm.lineNumber(), cm.sourceId());
                return true;
            }

            public void onConsoleMessage(String message, int lineNumber, String sourceID){
                //Log.d("androidruntime","Show console message, Used for debugging : " + message);

            }
        }); // End setWebChromeClient
    }

    // Run here when file select  from canera of from SDcard
    @Override
    protected void onActivityResult(int requestCode,int resultCode, Intent intent){
        if (null == this.mUploadMessage){
            return;
        }
        Uri result = null;
        try {
            if (resultCode !=RESULT_OK){
                result = null;
            }else{
                // retrieve from the private variable if the intent is null
                result = intent == null ? mCapturedImageURI : intent.getData();

            }
        }catch (Exception e){
            Toast.makeText(getApplicationContext(),"activity : "+e, Toast.LENGTH_LONG).show();
        }

        mUploadMessage.onReceiveValue(result);
        mUploadMessage = null;
    }

    // Open previous open link from history on webview when back button pressed
    @Override
    //Dectet when the back button is pressed
    public void onBackPressed(){
        if (webView.canGoForward()){
            webView.goBack();
        }else {
            // Let the system handle the back button
            super.onBackPressed();
        }
    }


// Fin de la classe WebView
}
