import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class TambahPeminjamanPage extends StatefulWidget {
  @override
  _TambahPeminjamanPageState createState() => _TambahPeminjamanPageState();
}

class _TambahPeminjamanPageState extends State<TambahPeminjamanPage> {
  DateTime? tanggalPinjam;
  DateTime? tanggalKembali;
  List bukuList = [];
  List<Map<String, dynamic>> items = [];

  @override
  void initState() {
    super.initState();
    fetchBuku();
  }

  Future<void> fetchBuku() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');
    final res = await http.get(
      Uri.parse('http://192.168.1.5:8000/api/buku'),
      headers: {'Authorization': 'Bearer $token'},
    );
    if (res.statusCode == 200) {
      setState(() {
        bukuList = jsonDecode(res.body);
      });
    }
  }

  void addItem() {
    setState(() {
      items.add({'buku_id': null, 'jumlah': 1});
    });
  }

  void removeItem(int index) {
    setState(() {
      items.removeAt(index);
    });
  }

  Future<void> submitForm() async {
    if (tanggalPinjam == null || tanggalKembali == null || items.any((e) => e['buku_id'] == null)) {
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text('Lengkapi semua data')));
      return;
    }

    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');

    final response = await http.post(
      Uri.parse('http://192.168.1.5:8000/api/peminjaman'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
      body: jsonEncode({
        'tanggal_pinjam': DateFormat('yyyy-MM-dd').format(tanggalPinjam!),
        'tanggal_kembali': DateFormat('yyyy-MM-dd').format(tanggalKembali!),
        'items': items,
      }),
    );

    if (response.statusCode == 201) {
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text('Peminjaman berhasil')));
      Navigator.pop(context);
    } else {
      print(response.body);
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text('Gagal menyimpan')));
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Form Peminjaman')),
      body: Padding(
        padding: EdgeInsets.all(16),
        child: ListView(
          children: [
            Text('Tanggal Pinjam'),
            ListTile(
              title: Text(tanggalPinjam == null
                  ? 'Pilih tanggal'
                  : DateFormat('yyyy-MM-dd').format(tanggalPinjam!)),
              trailing: Icon(Icons.calendar_today),
              onTap: () async {
                final picked = await showDatePicker(
                  context: context,
                  initialDate: DateTime.now(),
                  firstDate: DateTime(2020),
                  lastDate: DateTime(2030),
                );
                if (picked != null) setState(() => tanggalPinjam = picked);
              },
            ),
            SizedBox(height: 16),
            Text('Tanggal Kembali'),
            ListTile(
              title: Text(tanggalKembali == null
                  ? 'Pilih tanggal'
                  : DateFormat('yyyy-MM-dd').format(tanggalKembali!)),
              trailing: Icon(Icons.calendar_today),
              onTap: () async {
                final picked = await showDatePicker(
                  context: context,
                  initialDate: DateTime.now().add(Duration(days: 7)),
                  firstDate: DateTime(2020),
                  lastDate: DateTime(2030),
                );
                if (picked != null) setState(() => tanggalKembali = picked);
              },
            ),
            SizedBox(height: 24),
            Text('Daftar Buku'),
            ...items.asMap().entries.map((entry) {
              final i = entry.key;
              final item = entry.value;
              return Card(
                child: Padding(
                  padding: EdgeInsets.all(8),
                  child: Column(
                    children: [
                      DropdownButtonFormField(
                        value: item['buku_id'],
                        items: bukuList.map<DropdownMenuItem<int>>((buku) {
                          return DropdownMenuItem<int>(
                            value: buku['id'],
                            child: Text(buku['judul']),
                          );
                        }).toList(),
                        onChanged: (val) => setState(() => items[i]['buku_id'] = val),
                        decoration: InputDecoration(labelText: 'Pilih Buku'),
                      ),
                      TextFormField(
                        initialValue: item['jumlah'].toString(),
                        decoration: InputDecoration(labelText: 'Jumlah'),
                        keyboardType: TextInputType.number,
                        onChanged: (val) => items[i]['jumlah'] = int.tryParse(val) ?? 1,
                      ),
                      Align(
                        alignment: Alignment.centerRight,
                        child: IconButton(
                          icon: Icon(Icons.delete, color: Colors.red),
                          onPressed: () => removeItem(i),
                        ),
                      )
                    ],
                  ),
                ),
              );
            }),
            ElevatedButton.icon(
              onPressed: addItem,
              icon: Icon(Icons.add),
              label: Text('Tambah Buku'),
            ),
            SizedBox(height: 24),
            ElevatedButton(
              onPressed: submitForm,
              child: Text('Simpan Peminjaman'),
            )
          ],
        ),
      ),
    );
  }
}
