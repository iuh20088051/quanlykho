<?php
include ("clsqlkho.php");
class xuatkho extends quanlykho
{
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
	
	public function load_ds_xuat_nvl($sql)
	{
		$link=$this->connect();
		$kq=mysql_query($sql,$link);
		$i=mysql_num_rows($kq);
		if ($i>0)
		{
			echo '<table width="1300" border="1" align="center" cellpadding="1">
					<tbody>
					  <tr>
						<td width="50" align="center" valign="middle"><h3><strong>STT</strong></h3></td>
						<td width="350" height="50" align="center" valign="middle"><h3><strong></strong><strong>Tên nguyên vật liệu </strong></h3></td>
						<td width="100" height="50" align="center" valign="middle"><h3>Số lượng </h3></td>
						<td width="100" height="50" align="center" valign="middle"><h3><strong>Đơn vị tính </strong></h3></td>
						<td width="200" height="50" align="center" valign="middle"><h3><strong>Ngày xuất kho </strong></h3></td>
						<td width="200" height="50" align="center" valign="middle"><h3><strong>Ngày sản xuất </strong></h3></td>
						<td width="200" height="50" align="center" valign="middle"><h3><strong>Ngày hết hạn </strong></h3></td>
						<td width="100" height="50" align="center" valign="middle"><h3><strong>Mã phiếu nhập </strong></h3></td>
					  </tr>';
			
			$dem=1;
			while ($row=mysql_fetch_array($kq))
			{
				$id=$row['idNVL'];
				$tensp=$row['TenNVL'];
				$soluong=$row['Soluong'];
				$dvt=$row['DVT'];
				$ngayxuat=$row['Ngayxuat'];
				$ngaysx=$row['NgaySX'];
				$ngayhh=$row['HSD'];
				$idphieu=$row['idxuatnvl'];
				
				echo '<tr>
						<td height="50" align="center" valign="middle">'.$dem.'</td>
						<td height="50" align="center" valign="middle">'.$tensp.'</td>
						<td height="50" align="center" valign="middle">'.$soluong.'</td>
						<td height="50" align="center" valign="middle">'.$dvt.'</td>
						<td height="50" align="center" valign="middle">'.$ngayxuat.'</td>
						<td height="50" align="center" valign="middle">'.$ngaysx.'</td>
						<td height="50" align="center" valign="middle">'.$ngayhh.'</td>
						<td height="50" align="center" valign="middle">'.$idphieu.'</td>
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
	
	public function load_ds_xuat_tp($sql)
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
						<td width="350" height="50" align="center" valign="middle"><h3><strong></strong><strong>Tên thành phẩm </strong></h3></td>
						<td width="100" height="50" align="center" valign="middle"><h3>Số lượng </h3></td>
						<td width="100" height="50" align="center" valign="middle"><h3><strong>Đơn vị tính </strong></h3></td>
						<td width="200" height="50" align="center" valign="middle"><h3><strong>Ngày xuất kho </strong></h3></td>
						<td width="200" height="50" align="center" valign="middle"><h3><strong>Ngày sản xuất </strong></h3></td>
						<td width="200" height="50" align="center" valign="middle"><h3><strong>Ngày hết hạn </strong></h3></td>
						<td width="100" height="50" align="center" valign="middle"><h3><strong>Mã phiếu nhập </strong></h3></td>
					  </tr>';
			
			$dem=1;
			while ($row=mysql_fetch_array($kq))
			{
				$id=$row['idTP'];
				$tensp=$row['TenTP'];
				$soluong=$row['Soluong'];
				$dvt=$row['DVT'];
				$ngayxuat=$row['ngayxuat'];
				$ngaysx=$row['NgaySX'];
				$ngayhh=$row['HSD'];
				$idphieu=$row['idxuattp'];
				
				echo '<tr>
						<td height="50" align="center" valign="middle">'.$dem.'</td>
						<td height="50" align="center" valign="middle">'.$tensp.'</td>
						<td height="50" align="center" valign="middle">'.$soluong.'</td>
						<td height="50" align="center" valign="middle">'.$dvt.'</td>
						<td height="50" align="center" valign="middle">'.$ngayxuat.'</td>
						<td height="50" align="center" valign="middle">'.$ngaysx.'</td>
						<td height="50" align="center" valign="middle">'.$ngayhh.'</td>
						<td height="50" align="center" valign="middle">'.$idphieu.'</td>
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
	
}
?>