<?php
class xemBCTK
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

public function load_ds_tp($sql)
	{
		$link=$this->connect();
		$kq=mysql_query($sql,$link);
		$i=mysql_num_rows($kq);
		if ($i>0)
		{
					echo '<table width="800" border="1" align="center">
				  <tbody>
					<tr>
					  <td width="78" align="center"><strong>ID</strong></td>
					  <td width="148" height="88" align="center"><strong>TÊN THÀNH PHẨM </strong></td>
					  <td width="121" align="center"><strong>SỐ LƯỢNG</strong></td>
					  <td width="81" align="center"> <strong>NGÀY SẢN XUẤT</strong></td>
					  <td width="81" align="center"> <strong>HẠN SỬ DỤNG</strong></td>
					</tr>';				
			$dem=1;
			while ($row=mysql_fetch_array($kq))
			{
				$id=$row['IDTP'];
				$tensp=$row['TenTP'];
				$sl=$row['Soluong'];
				$nsx=$row['NgaySX'];
				$hsd=$row['HSD'];
				echo ' <tr> 
					  <td align="center">'.$dem.'</td>
					  <td align="center"> '.$tensp.'</td>
					  <td align="center">'.$sl.'</td>
					   <td align="center">'.$nsx.'</td>
					    <td align="center">'.$hsd.'</td>
					</tr>';
				 $dem++;
			}
		}
		else 
		{
			echo 'Không có dữ liệu';
		}
		mysql_close($link);
	}
	public function load_ds_nvl($sql)
	{
		$link=$this->connect();
		$kq=mysql_query($sql,$link);
		$i=mysql_num_rows($kq);
		if ($i>0)
		{
			echo '<table width="800" border="1" align="center">
				  <tbody>
					<tr>
					  <td width="78" align="center"><strong>ID</strong></td>
					  <td width="148" height="88" align="center"><strong>TÊN NGUYÊN VẬT LIỆU</strong></td>
					  <td width="176" align="center"><strong>SỐ LƯỢNG</strong></td>
					  <td width="121" align="center"><strong>NGÀY SẢN XUẤT</strong></td>
					  <td width="121" align="center"><strong>HẠN SỬ DỤNG</strong></td>
					</tr>';
									
			$dem=1;
			while ($row=mysql_fetch_array($kq))
			{
				$id=$row['idNVL'];
				$tensp=$row['TenNVL'];
				$sl=$row['Soluong'];
				$nsx=$row['NgaySX'];
				$hsd=$row['HSD'];
				echo ' <tr> 
					  <td align="center">'.$dem.'</td>
					  <td align="center"> '.$tensp.'</td>
					  <td align="center">'.$sl.'</td>
					  <td align="center">'.$nsx.'</td>
					   <td align="center">'.$hsd.'</td>
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