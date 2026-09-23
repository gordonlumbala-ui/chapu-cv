import 'dart:convert';

import 'package:http/http.dart' as http;

import '../core/app_constants.dart';
import 'api_exception.dart';

class ApiClient {
  ApiClient({http.Client? client}) : _client = client ?? http.Client();

  final http.Client _client;
  String? _token;

  String? get token => _token;

  void setToken(String? token) {
    _token = token;
  }

  Uri _uri(String path) {
    final normalized = path.startsWith('/') ? path : '/$path';
    return Uri.parse('${AppConstants.apiBaseUrl}$normalized');
  }

  Map<String, String> _headers({bool jsonBody = false}) {
    return {
      'Accept': 'application/json',
      if (jsonBody) 'Content-Type': 'application/json',
      if (_token != null && _token!.isNotEmpty) 'Authorization': 'Bearer $_token',
    };
  }

  Future<Map<String, dynamic>> get(String path) async {
    final response = await _client.get(_uri(path), headers: _headers());
    return _decode(response);
  }

  Future<Map<String, dynamic>> post(String path, {Map<String, dynamic>? body}) async {
    final response = await _client.post(
      _uri(path),
      headers: _headers(jsonBody: true),
      body: jsonEncode(body ?? {}),
    );
    return _decode(response);
  }

  Future<Map<String, dynamic>> put(String path, {Map<String, dynamic>? body}) async {
    final response = await _client.put(
      _uri(path),
      headers: _headers(jsonBody: true),
      body: jsonEncode(body ?? {}),
    );
    return _decode(response);
  }

  Future<Map<String, dynamic>> delete(String path) async {
    final response = await _client.delete(_uri(path), headers: _headers());
    return _decode(response);
  }

  Map<String, dynamic> _decode(http.Response response) {
    Map<String, dynamic> payload = {};
    if (response.body.isNotEmpty) {
      final decoded = jsonDecode(response.body);
      if (decoded is Map<String, dynamic>) {
        payload = decoded;
      }
    }

    if (response.statusCode >= 200 && response.statusCode < 300) {
      return payload;
    }

    final errors = payload['errors'];
    throw ApiException(
      payload['message']?.toString() ?? 'Request failed (${response.statusCode}).',
      statusCode: response.statusCode,
      errors: errors is Map<String, dynamic> ? errors : null,
    );
  }
}
