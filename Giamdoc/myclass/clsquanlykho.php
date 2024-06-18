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
					  <td width="176" align="center"><strong>DVT</strong></td>
					  <td width="121" align="center"><strong>SỐ LƯỢNG</strong></td>
					  <td width="121" align="center"><strong>KHO</strong></td>
					</tr>';
									
			$dem=1;
			while ($row=mysql_fetch_array($kq))
			{
				$id=$row['idNVL'];
				$tensp=$row['TenNVL'];
				$dvt=$row['DVT'];
				$sl=$row['Soluong'];
				$kho=$row['idkho'];
				echo ' <tr> 
					  <td align="center"><a href="?layid='.$id.'">'.$dem.'</td>
					  <td align="center"><a href="?layid='.$id.'"> '.$tensp.'</td>
					  <td align="center"><a href="?layid='.$id.'">'.$dvt.'</td>
					  <td align="center"><a href="?layid='.$id.'">'.$sl.'</td>
					   <td align="center"><a href="?layid='.$id.'">'.$kho.'</td>
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
        			<option value="a">Chọn kho muốn nhập</option>';
			while ($row=mysql_fetch_array($kq))
			{
				$id=$row['IDKHO'];
				$tenkho=$row['TenKho'];
				if ($id==$idkho)
				{
					echo '<option value="'.$id.'" selected>'.$tenkho.'</option>';
				}
				else 
				{
					echo '<option value="'.$id.'">'.$tenkho.'</option>';
				}
				
			}
			echo '</select>';
		}
		else 
		{
			echo'Không có dữ liệu';
		}
		mysql_close($link);
		
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
					  <td width="81" align="center"> <strong>KHO</strong></td>
					  
					</tr>';
									
			$dem=1;
			while ($row=mysql_fetch_array($kq))
			{
				$id=$row['IDTP'];
				$tensp=$row['TenTP'];
				$sl=$row['Soluong'];
				$kho=$row['idkho'];
				echo ' <tr> 
					  <td align="center"><a href="?layid='.$id.'">'.$dem.'</td>
					  <td align="center"><a href="?layid='.$id.'"> '.$tensp.'</td>
					  <td align="center"><a href="?layid='.$id.'">'.$sl.'</td>
					  <td align="center"><a href="?layid='.$id.'">'.$kho.'</td>
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
	public function laycot($sql)
	{
		$link=$this->connect();
		$kq=mysql_query($sql,$link);
		$i=mysql_num_rows($kq);
		$giatri='';
		if ($i>0)
		{
			
			while ($row=mysql_fetch_array($kq))
			{
				$giatri=$row[0];
				
			}
		}
		return $giatri;
	}
	
}
?>