import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';

class HomePage extends StatefulWidget {
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  List riwayat = [];

  Future<void> fetchData() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');
    final res = await http.get(
      Uri.parse('http://192.168.1.5:8000/api/peminjaman'),
      headers: {'Authorization': 'Bearer $token'},
    );
    if (res.statusCode == 200) {
      setState(() {
        riwayat = jsonDecode(res.body);
      });
    }
  }

  @override
  void initState() {
    fetchData();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Riwayat Peminjaman')),
      body: ListView.builder(
        itemCount: riwayat.length,
        itemBuilder: (context, i) {
          final item = riwayat[i];
          return ListTile(
            title: Text("Pinjam: ${item['tanggal_pinjam']}"),
            subtitle: Text("Kembali: ${item['tanggal_kembali']}"),
          );
        },
      ),
    );
  }
}
