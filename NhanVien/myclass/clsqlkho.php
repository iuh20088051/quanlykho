<?php
class quanlykho
{
	public function connect()
	{
		$con=mysql_connect("localhost","qlkho","123456");
		if(!$con)
		{
			echo 'Không kết nối được với CSDL';
			exit ();
		}
		else 
		{
			mysql_select_db("quanlykho");
			mysql_query("SET NAMES UTF8");
			return $con;
		}
	}
	
	public function themxoasua($sql)
	 {
		$link=$this->connect();
		if(mysql_query($sql,$link))
		{
			return 1;
		}
		else
		{
			return 0;
		}	 
	 }
	 
	 public function load_ds_bien_ban($sql)
	{
		$link=$this->connect();
		$kq=mysql_query($sql,$link);
		$i=mysql_num_rows($kq);
		if ($i>0)
		{
			echo '<table width="1300" border="1" align="center" cellpadding="2">
					<tbody>
					  <tr>
						<td width="50" align="center" valign="middle"><h3><strong>STT</strong></h3></td>
						<td width="100" align="center" valign="middle"><h3><strong>Mã phiếu</strong></h3></td>
						<td width="200" height="50" align="center" valign="middle"><h3><strong></strong><strong>Tên nguyên vật liệu</strong></h3></td>
						<td width="150" height="50" align="center" valign="middle"><h3>Ngày mua</h3></td>
						<td width="150" height="50" align="center" valign="middle"><h3><strong>Ngày sản xuất </strong></h3></td>
						<td width="150" height="50" align="center" valign="middle"><h3><strong>Ngày hết hạn </strong></h3></td>
						<td width="500" height="50" align="center" valign="middle"><h3><strong>Ghi chú </strong></h3></td>
					  </tr>';
			
			$dem=1;
			while ($row=mysql_fetch_array($kq))
			{
				$id=$row['idbienban'];
				$ma=$row['maphieu'];
				$tensp=$row['tenNVL'];
				$ngaymua=$row['ngaymua'];
				$ngaysx=$row['nsx'];
				$ngayhh=$row['hsd'];
				$ghichu=$row['ghichu'];
				
				echo '<tr>
						<td height="50" align="center" valign="middle">'.$dem.'</td>
						<td height="50" align="center" valign="middle">'.$ma.'</td>
						<td height="50" align="center" valign="middle">'.$tensp.'</td>
						<td height="50" align="center" valign="middle">'.$ngaymua.'</td>
						<td height="50" align="center" valign="middle">'.$ngaysx.'</td>
						<td height="50" align="center" valign="middle">'.$ngayhh.'</td>
						<td height="50" align="center" valign="middle">'.$ghichu.'</td>
					  </tr>';
				 $dem++;
			}
			echo '</tbody>
				</table>';
		}
		else 
		{
			echo 'Không có dữ liệu';
		}
		mysql_close($link);
	}
	
	public function loadcombo_kho($sql,$idkho)
	{
		$link=$this->connect();
		$kq=mysql_query($sql,$link);
		$i=mysql_num_rows($kq);
		if($i>0)
		{ 
			echo '<select name="tenkho" id="tenkho">
        			<option value="a">Chọn kho muốn thực hiện </option>';
			while ($row=mysql_fetch_array($kq))
			{
				$id=$row['IDKHO'];
				$tenkho=$row['TenKho'];
				echo '<option value="'.$id.'">'.$tenkho.'</option>';
			}
			echo '</select>';
		}
		else 
		{
			echo'Không có dữ liệu';
		}
		mysql_close($link);
		
	}
	
	public function loadcombo_nhanvien($sql,$idnv)
	{
		$link=$this->connect();
		$kq=mysql_query($sql,$link);
		$i=mysql_num_rows($kq);
		if($i>0)
		{ 
			echo '<select name="tennv" id="tennv">
        			<option value="a">Nhân viên thực hiện</option>';
			while ($row=mysql_fetch_array($kq))
			{
				$id=$row['IDNV'];
				$tennv=$row['TenNV'];
				echo '<option value="'.$id.'">'.$tennv.'</option>';
			}
			echo '</select>';
		}
		else 
		{
			echo'Không có dữ liệu';
		}
		mysql_close($link);
		
	}
	

}
?>