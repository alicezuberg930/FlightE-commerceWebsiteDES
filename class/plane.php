<?php require_once("../../connection.php");
require_once("../../DESAlgorithm.php");
class plane
{
    public function AddPlane($Obj)
    {
        $PlaneID = $Obj["PlaneID"];
        $PlaneName = utf8_encode(EncryptPlaintext($Obj["PlaneName"]));
        $Rows = utf8_encode(EncryptPlaintext($Obj["Rows"]));
        $Columns = utf8_encode(EncryptPlaintext($Obj["Columns"]));
        $BusinessRow = utf8_encode(EncryptPlaintext($Obj["BusinessRow"]));
        $SeatAmount = utf8_encode(EncryptPlaintext($Obj["SeatAmount"]));
        return Query("insert into plane(PlaneID, PlaneName, SeatAmount, PlaneRows, PlaneColumns, BusinessClassRow) 
        values('" . $PlaneID . "', q'[" . $PlaneName . "]',q'[" . $SeatAmount . "]',q'[" . $Rows . "]',q'[" . $Columns . "]',q'[" . $BusinessRow . "]')");
    }
    public function DeletePlane($ID)
    {
        return Query("delete from plane where PlaneID = '" . $ID . "'");
    }
    public function UpdatePlane($Obj)
    {
        $PlaneID = $Obj["PlaneID"];
        $PlaneName = utf8_encode(EncryptPlaintext($Obj["PlaneName"]));
        $Rows = utf8_encode(EncryptPlaintext($Obj["Rows"]));
        $Columns = utf8_encode(EncryptPlaintext($Obj["Columns"]));
        $BusinessRow = utf8_encode(EncryptPlaintext($Obj["BusinessRow"]));
        $SeatAmount = utf8_encode(EncryptPlaintext($Obj["SeatAmount"]));
        $HiddenPlaneID = $Obj["HiddenPlaneID"];
        return Query("update plane set PlaneID='$PlaneID',PlaneName=q'[$PlaneName]',SeatAmount=q'[$SeatAmount]',
        PlaneRows=q'[$Rows]',PlaneColumns=q'[$Columns]',BusinessClassRow=q'[$BusinessRow]' WHERE PlaneID='" . $HiddenPlaneID . "'");
    }
    public function SearchPlane($SQL)
    {
        return GetObjectArray("select * from plane " . $SQL);
    }
    public function GetPlane($StartFrom, $Quantity)
    {
        return GetObjectArray("select * from plane order by PlaneID asc offset $StartFrom rows fetch next $Quantity row only");
    }
}
$PlaneObject  = new plane();
