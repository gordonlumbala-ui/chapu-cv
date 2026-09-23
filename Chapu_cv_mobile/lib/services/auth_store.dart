import 'package:flutter/foundation.dart';
import 'package:shared_preferences/shared_preferences.dart';

import 'api_client.dart';
import 'api_exception.dart';

class AuthStore extends ChangeNotifier {
  AuthStore(this._api);

  static const _tokenKey = 'chapu_api_token';
  static const _userKey = 'chapu_api_user_name';
  static const _emailKey = 'chapu_api_user_email';

  final ApiClient _api;

  bool _loaded = false;
  bool _busy = false;
  String? _token;
  String? _name;
  String? _email;
  String? _error;

  bool get isLoaded => _loaded;
  bool get isBusy => _busy;
  bool get isAuthenticated => _token != null && _token!.isNotEmpty;
  String? get name => _name;
  String? get email => _email;
  String? get error => _error;

  Future<void> load() async {
    final prefs = await SharedPreferences.getInstance();
    _token = prefs.getString(_tokenKey);
    _name = prefs.getString(_userKey);
    _email = prefs.getString(_emailKey);
    _api.setToken(_token);
    _loaded = true;
    notifyListeners();
  }

  Future<bool> login({required String email, required String password}) async {
    return _authenticate('/login', {
      'email': email.trim(),
      'password': password,
    });
  }

  Future<bool> register({
    required String name,
    required String email,
    required String password,
    required String passwordConfirmation,
  }) async {
    return _authenticate('/register', {
      'name': name.trim(),
      'email': email.trim(),
      'password': password,
      'password_confirmation': passwordConfirmation,
    });
  }

  Future<bool> _authenticate(String path, Map<String, dynamic> body) async {
    _busy = true;
    _error = null;
    notifyListeners();

    try {
      final response = await _api.post(path, body: body);
      final data = response['data'] as Map<String, dynamic>? ?? {};
      final user = data['user'] as Map<String, dynamic>? ?? {};
      final token = data['token']?.toString();

      if (token == null || token.isEmpty) {
        throw ApiException('No auth token returned by the server.');
      }

      await _persist(
        token: token,
        name: user['name']?.toString(),
        email: user['email']?.toString(),
      );
      return true;
    } on ApiException catch (e) {
      _error = e.message;
      return false;
    } catch (_) {
      _error = 'Could not reach the server. Check API_BASE_URL and that Laravel is running.';
      return false;
    } finally {
      _busy = false;
      notifyListeners();
    }
  }

  Future<void> logout() async {
    try {
      if (isAuthenticated) {
        await _api.post('/logout');
      }
    } catch (_) {
      // Ignore network errors on logout; clear local session anyway.
    }

    final prefs = await SharedPreferences.getInstance();
    await prefs.remove(_tokenKey);
    await prefs.remove(_userKey);
    await prefs.remove(_emailKey);
    _token = null;
    _name = null;
    _email = null;
    _api.setToken(null);
    notifyListeners();
  }

  Future<void> _persist({
    required String token,
    String? name,
    String? email,
  }) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString(_tokenKey, token);
    if (name != null) await prefs.setString(_userKey, name);
    if (email != null) await prefs.setString(_emailKey, email);

    _token = token;
    _name = name;
    _email = email;
    _api.setToken(token);
  }
}
