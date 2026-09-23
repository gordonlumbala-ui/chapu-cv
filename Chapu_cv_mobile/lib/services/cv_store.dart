import 'package:flutter/foundation.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../models/cv_data.dart';
import 'api_client.dart';
import 'api_exception.dart';

class CvStore extends ChangeNotifier {
  CvStore(this._api);

  static const _key = 'chapu_cv_data';
  static const _startedKey = 'chapu_has_started';

  final ApiClient _api;

  CvData _cv = const CvData();
  bool _hasStarted = false;
  bool _loaded = false;
  bool _syncing = false;
  String? _syncError;

  CvData get cv => _cv;
  bool get hasStarted => _hasStarted;
  bool get isLoaded => _loaded;
  bool get isSyncing => _syncing;
  String? get syncError => _syncError;

  Future<void> load() async {
    final prefs = await SharedPreferences.getInstance();
    _hasStarted = prefs.getBool(_startedKey) ?? false;
    final raw = prefs.getStringList(_key);
    if (raw != null && raw.length == 9) {
      _cv = CvData(
        fullName: raw[0],
        jobTitle: raw[1],
        email: raw[2],
        phone: raw[3],
        location: raw[4],
        summary: raw[5],
        experience: raw[6],
        education: raw[7],
        skills: raw[8],
      );
    }
    _loaded = true;
    notifyListeners();
  }

  Future<void> markStarted() async {
    _hasStarted = true;
    final prefs = await SharedPreferences.getInstance();
    await prefs.setBool(_startedKey, true);
    notifyListeners();
  }

  Future<void> saveLocal(CvData data) async {
    _cv = data;
    final prefs = await SharedPreferences.getInstance();
    await prefs.setStringList(_key, [
      data.fullName,
      data.jobTitle,
      data.email,
      data.phone,
      data.location,
      data.summary,
      data.experience,
      data.education,
      data.skills,
    ]);
    notifyListeners();
  }

  /// Saves locally and syncs to the Laravel API when authenticated.
  Future<void> save(CvData data, {required bool authenticated}) async {
    await saveLocal(data);

    if (!authenticated) {
      _syncError = null;
      return;
    }

    _syncing = true;
    _syncError = null;
    notifyListeners();

    try {
      final response = await _api.post('/mobile/cv/sync', body: {
        'full_name': data.fullName,
        'job_title': data.jobTitle,
        'email': data.email,
        'phone': data.phone,
        'location': data.location,
        'summary': data.summary,
        'experience': data.experience,
        'education': data.education,
        'skills': data.skills,
      });

      final payload = response['data'] as Map<String, dynamic>? ?? {};
      final mobile = payload['mobile'] as Map<String, dynamic>?;
      if (mobile != null) {
        await saveLocal(CvData.fromApi(mobile));
      }
    } on ApiException catch (e) {
      _syncError = e.message;
      rethrow;
    } catch (_) {
      _syncError = 'Could not sync CV to the server.';
      rethrow;
    } finally {
      _syncing = false;
      notifyListeners();
    }
  }

  Future<void> pullFromApi() async {
    _syncing = true;
    _syncError = null;
    notifyListeners();

    try {
      final response = await _api.get('/mobile/cv');
      final data = response['data'] as Map<String, dynamic>? ?? {};
      await saveLocal(CvData.fromApi(data));
      await markStarted();
    } on ApiException catch (e) {
      _syncError = e.message;
    } catch (_) {
      _syncError = 'Could not load CV from the server.';
    } finally {
      _syncing = false;
      notifyListeners();
    }
  }
}
