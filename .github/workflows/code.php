function hecele($kelime, $diziOlarakDondur=false, $hecele=false) {
        $sessiz         = "[bcçdfgğhjklmnprsştvyz]";
        $sesli          = "[aeıioöuü]";
 
        $kelime = preg_replace('/[^a-zA-ZığüşçöİĞÜŞÇÖ]/ui', '', $kelime);
 
        $kelime = preg_replace("/({$sessiz}+)({$sessiz}+)(?={$sesli})/ui", "\\1-\\2", $kelime);
 
        $bol = explode('-', $kelime);
        for($i=0; $i<count($bol); $i++) {
                $bol[$i] = strlen($bol[$i])>3 ? preg_replace("/({$sesli}+)({$sessiz}+)(?={$sesli}+)/ui", "\\1-\\2\\3", $bol[$i]) : $bol[$i];
        }
 
        if($diziOlarakDondur===true && $hecele===false) {
                $bol = implode('-', $bol);
                return explode("-", $bol);
        } else {
                return implode('-', $bol);
        }
}
 
function iyelikEkle($kelime) {
        $hece = hecele($kelime, true);
        $sonHece = $hece[count($hece)-1];
 
        $kalinSesli = "aıou";
        $inceSesli = "eiöü";
        $sonHarf = ord(substr($sonHece, -1)) > 122 ? substr($sonHece, -2) : substr($sonHece, -1);
        $ek = "";
 
        if(preg_match("/[{$kalinSesli}{$inceSesli}]+/ui", $sonHarf)) {
                //Son harf sesli
                switch($sonHarf) {
                        case "a":
                        case "A":
                        case "I":
                        case "ı":
                                $ek = "nın";
                                break;
                        case "e":
                        case "E":
                        case "i":
                        case 'İ':
                                $ek = "nin";
                                break;
                        case "o":
                        case "O":
                        case "u":
                        case "U":
                                $ek = "nun";
                                break;
                        case "ö":
                        case "Ö":
                        case "ü":
                        case 'Ü':
                                $ek = "nün";
                                break;
                }
        } else {
                //Son harf sessiz
                if(preg_match("/[aı]+/ui", $sonHece)) {
                        $ek = 'ın';
                } elseif(preg_match("/[ei]+/ui", $sonHece)) {
                        $ek = 'in';
                } elseif(preg_match("/[ou]+/ui", $sonHece)) {
                        $ek = 'un';
                } elseif(preg_match("/[öü]+/ui", $sonHece)) {
                        $ek = 'ün';
                }
        }
 
        // Büyük İ karakterinde çıkan sorun için bu satır kalmalı
        $ek = empty($ek) ? 'nin' : $ek;
        return implode('', $hece).'\''.$ek;
}
 
function cumleHecele($cumle, $diziOlarakDondur=false) {
        $bol = explode(' ', $cumle);
        $sonuc = array();
       
        foreach($bol as $kelime) {
                $sonuc[] = hecele($kelime, $diziOlarakDondur);
        }
 
        return(implode(' ', $sonuc));
}
 
//print_r(cumleHecele('isimlerin son hecelerine göre sonuna eklenecek takıyı belirleyen bir fonksiyon var mıdır? örn: Ahmet`in Osman`ın gibi sondaki "ın" "in" takılarını öncesinde gelen isme yada ismin son hecesine göre otomatik getiren bir yapı.', true));
 
//print_r(hecele("fanatikleştirebildiklerimizdenmisiniz", true));
 
echo(iyelikEkle("Malik"));
